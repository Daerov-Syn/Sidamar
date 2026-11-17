import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { test } from 'node:test';
import { generateRuntimeFunction } from '../../node_modules/@alpinejs/csp/src/parser.js';
import serviceDetail from '../../resources/js/service-detail.js';
import serviceMap from '../../resources/js/service-map.js';

test('service page expressions are accepted by the installed CSP parser', () => {
    const views = [
        '../../resources/views/public/layanan-detail.blade.php',
        '../../resources/views/components/service-map.blade.php',
        '../../resources/views/layouts/public.blade.php',
        '../../resources/views/layouts/admin.blade.php',
        '../../resources/views/components/star-rating.blade.php',
    ];
    let expressionsChecked = 0;

    for (const view of views) {
        const markup = readFileSync(new URL(view, import.meta.url), 'utf8').replace(/\{\{[\s\S]*?\}\}/g, '0');
        const attributes = markup.matchAll(/\s(?:x-(?:data|on:[\w.:-]+|text|show|model|bind:[\w.:-]+)|:[\w.-]+)="([^"]*)"/g);

        for (const [, expression] of attributes) {
            assert.doesNotThrow(() => generateRuntimeFunction(expression), `${view}: ${expression}`);
            expressionsChecked++;
        }
    }

    assert.ok(expressionsChecked > 50);
});

test('document checklist persists per service and FAQ filtering keeps working', () => {
    const savedDocuments = new Map([['sidamar_docs_stnk-duplikat', '[0,9,"1"]']]);
    globalThis.localStorage = {
        getItem: (key) => savedDocuments.get(key) || null,
        setItem: (key, value) => savedDocuments.set(key, value),
    };
    const state = serviceDetail();
    state.$el = { dataset: {
        storageKey: 'sidamar_docs_stnk-duplikat',
        documentCount: '2',
        faqs: JSON.stringify([{ q: 'BPKB di leasing?', a: 'Bawa surat keterangan.' }]),
    } };
    state.init();

    assert.deepEqual(state.checkedDocs, [0]);
    assert.equal(state.progressPercent, 50);
    state.toggleDoc(1);
    assert.equal(state.isAllReady, true);
    assert.equal(savedDocuments.get(state.storageKey), '[0,1]');
    state.markAll();
    assert.equal(state.readyCount, 0);
    state.markAll();
    assert.equal(state.readyCount, 2);
    state.faqSearch = ' bpkb ';
    assert.equal(state.filteredFaqs().length, 1);
    state.faqSearch = 'surat keterangan';
    assert.equal(state.filteredFaqs().length, 1);
    state.faqSearch = 'tidak ditemukan';
    assert.equal(state.filteredFaqs().length, 0);

    const nextService = serviceDetail();
    nextService.$el = { dataset: { ...state.$el.dataset, storageKey: 'sidamar_docs_mutasi-keluar' } };
    nextService.init();
    assert.deepEqual(nextService.checkedDocs, []);

    globalThis.localStorage = {
        getItem() { throw new Error('Storage unavailable'); },
        setItem() { throw new Error('Storage unavailable'); },
    };
    nextService.init();
    assert.doesNotThrow(() => nextService.toggleDoc(0));
    assert.equal(nextService.readyCount, 1);
});

test('CSP event expressions select steps and initialize each service from its own data', () => {
    globalThis.HTMLIFrameElement = class {};
    globalThis.HTMLScriptElement = class {};
    const selectedSteps = [];
    const service = { nama: 'STNK Duplikat', langkah: [{ teks: 'Antrian' }, { teks: 'Kasir' }], berkas: [] };
    const state = serviceMap();
    state.$el = { dataset: { service: JSON.stringify(service), planUrl: '/denah-samsat.html' } };
    state.init();
    state.$refs = { steps: {
        querySelector: () => ({ offsetTop: 0, clientHeight: 44 }),
        scrollTo() {}, offsetTop: 0, clientHeight: 300,
    } };
    state.$nextTick = async (callback) => callback();
    globalThis.matchMedia = () => ({ matches: true });
    assert.equal(state.service.nama, 'STNK Duplikat');
    assert.equal(state.activeIndex, 0);

    generateRuntimeFunction('selectStep(activeIndex + 1)')({ scope: state, forceBindingRootScopeToFunctions: true });
    assert.equal(state.activeIndex, 1);
    generateRuntimeFunction('selectStep(index)')({ scope: Object.assign(state, { index: 0 }), forceBindingRootScopeToFunctions: true });
    assert.equal(state.activeIndex, 0);

    state.openMap = (index) => selectedSteps.push(index);
    generateRuntimeFunction('openFromEvent($event)')({
        scope: Object.assign(state, { $event: { detail: { step: 1 } } }),
        forceBindingRootScopeToFunctions: true,
    });
    assert.deepEqual(selectedSteps, [1]);

    const nextService = serviceMap();
    nextService.$el = { dataset: {
        service: JSON.stringify({ nama: 'Mutasi Keluar', langkah: [{ teks: 'Antrian MTC' }], berkas: [{ teks: 'BPKB' }] }),
        planUrl: '/denah-samsat.html',
    } };
    nextService.init();
    assert.equal(nextService.activeIndex, 0);
    assert.equal(nextService.service.nama, 'Mutasi Keluar');
    assert.equal(nextService.service.berkas[0].teks, 'BPKB');
});
