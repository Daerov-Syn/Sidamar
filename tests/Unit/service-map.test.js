import assert from 'node:assert/strict';
import { test } from 'node:test';
import { buildRoute, locateStep } from '../../resources/js/service-map-data.js';
import serviceMap from '../../resources/js/service-map.js';

const places = [
    { id: '9', name: '9. Kasir 1–5', x: 3.63, z: 1.28, width: 0.91, depth: 1.26 },
    { id: '14', name: '14. Layanan Fiskal', x: 8.63, z: 1.28, width: 0.91, depth: 1.26 },
    { id: '7', name: '7. Penyerahan STNK & TNKB', x: 1.63, z: 1.28, width: 0.91, depth: 1.26 },
];

test('repeated counter visits retain every step number at one location', () => {
    const steps = [
        { teks: 'Bayar', kode_loket: 'KAS' },
        { teks: 'Fiskal', kode_loket: 'FISKAL' },
        { teks: 'Kembali ke kasir', kode_loket: ' kas ' },
    ];
    const result = buildRoute(steps, places);

    assert.equal(result.locations.length, 2);
    assert.deepEqual(result.locations[0].steps, [0, 2]);
    assert.equal(result.route[0].location, result.route[2].location);
    assert.equal(result.route[0].location.x, 4.085);
    assert.deepEqual(result.route.map((step) => step.teks), steps.map((step) => step.teks));
});

test('unknown and legacy locations stay schematic without inferred rooms or documents', () => {
    const steps = [{ teks: 'Siapkan berkas' }, { teks: 'Antrian MTC', kode_loket: 'MTC' }];
    const result = buildRoute(steps, places);

    assert.equal(result.locations.length, 2);
    assert.ok(result.locations.every((location) => !location.mapped));
    assert.equal(result.route[0].kode_loket, undefined);
    assert.equal(locateStep({ kode_loket: 'P', teks: 'Penyerahan STNK + BPKB' }, places), null);
    assert.equal(locateStep({ kode_loket: 'P', teks: 'Penyerahan STNK' }, places).id, '7');
    assert.deepEqual(buildRoute([], places), { route: [], locations: [] });
});

test('physical inspection highlights both vehicle areas from the asset', () => {
    const physicalAreas = [
        { id: '1', x: 19.35, z: 4.55, width: 2.21, depth: 1.26 },
        { id: '2', x: 20, z: 2.18, width: 1.56, depth: 1.52 },
    ];
    const result = buildRoute([{ teks: 'Cek Fisik', kode_loket: 'CF' }], physicalAreas);
    assert.deepEqual(result.locations[0].placeIds, ['1', '2']);
    assert.equal(result.locations[0].mapped, true);
    assert.equal(result.locations[0].name, 'Area Cek Fisik Roda 2 / Roda 4');
});

function installFallbackEnvironment() {
    const context = new Proxy({}, { get: () => () => {} });
    const pins = Array.from({ length: 20 }, () => ({ style: {}, hidden: false }));
    globalThis.document = {
        activeElement: { focus() {} },
        documentElement: { classList: { add() {}, remove() {} } },
        createElement: () => ({ style: {}, setAttribute() {}, getContext: () => context, remove() {} }),
    };
    globalThis.fetch = async () => ({ ok: false });
    globalThis.devicePixelRatio = 1;
    globalThis.matchMedia = () => ({ matches: true });
    globalThis.ResizeObserver = class {
        observe() {}
        disconnect() {}
    };

    return {
        dialog: { open: false, showModal() { this.open = true; }, close() { this.open = false; } },
        canvas: { clientWidth: 390, clientHeight: 330, append() {} },
        pins: { querySelectorAll: () => pins },
        steps: { querySelector: () => ({ offsetTop: 0, clientHeight: 44 }), scrollTo() {}, offsetTop: 0, clientHeight: 300 },
    };
}

test('fallback supports navigation, boundaries, reopening, and a fresh service at step one', async () => {
    const references = installFallbackEnvironment();
    const stnk = serviceMap({ nama: 'STNK Duplikat', langkah: [
        { teks: 'Antrian MTC', kode_loket: 'MTC', keterangan: 'Ambil nomor antrian' },
        { teks: 'Kasir', kode_loket: 'KAS', keterangan: 'Biaya STNK' },
    ], berkas: [{ teks: 'Surat kehilangan' }] }, '/denah-samsat.html');
    stnk.$refs = references;
    stnk.$nextTick = async (callback) => callback?.();

    await stnk.openMap();
    assert.equal(stnk.mode, '2D');
    assert.equal(stnk.activeIndex, 0);
    assert.equal(stnk.loading, false);
    assert.match(stnk.status, /WebGL/);
    stnk.selectStep(1);
    assert.equal(stnk.currentStep.keterangan, 'Biaya STNK');
    assert.equal(stnk.currentLocation.steps[0], 1);
    stnk.selectStep(2);
    assert.equal(stnk.activeIndex, 1);
    stnk.selectStep(0);
    stnk.selectStep(-1);
    assert.equal(stnk.activeIndex, 0);
    stnk.overview();
    stnk.zoom(1.3);
    stnk.closeMap();
    stnk.cleanup();
    await stnk.openMap(1);
    assert.equal(stnk.activeIndex, 1);
    stnk.closeMap();
    stnk.cleanup();
    await stnk.openMap();
    assert.equal(stnk.activeIndex, 0);
    stnk.closeMap();
    stnk.cleanup();

    const mutasi = serviceMap({ nama: 'Mutasi Keluar', langkah: [
        { teks: 'Antrian MTC', kode_loket: 'MTC' },
        { teks: 'Fiskal', kode_loket: 'FISKAL', keterangan: 'Berkas cabutan' },
    ], berkas: [{ teks: 'BPKB' }] }, '/denah-samsat.html');
    mutasi.$refs = references;
    mutasi.$nextTick = stnk.$nextTick;
    await mutasi.openMap();
    assert.equal(mutasi.activeIndex, 0);
    assert.equal(mutasi.service.nama, 'Mutasi Keluar');
    assert.equal(mutasi.service.berkas[0].teks, 'BPKB');
    mutasi.selectStep(1);
    assert.equal(mutasi.currentStep.kode_loket, 'FISKAL');
    assert.equal(mutasi.route[1].teks, 'Fiskal');
    mutasi.closeMap();
    mutasi.cleanup();
});

test('closing during an asset request prevents a stale viewer from mounting', async () => {
    const references = installFallbackEnvironment();
    let resolveFetch;
    globalThis.fetch = () => new Promise((resolve) => { resolveFetch = resolve; });
    const state = serviceMap({ nama: 'Layanan', langkah: [{ teks: 'Mulai' }], berkas: [] }, '/plan');
    state.$refs = references;
    state.$nextTick = async (callback) => callback?.();
    const opening = state.openMap();
    state.closeMap();
    state.cleanup();
    resolveFetch({ ok: false });
    await opening;
    assert.deepEqual(state.locations, []);
    assert.equal(state.loading, false);
});
