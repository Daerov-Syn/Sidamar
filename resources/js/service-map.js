import { buildRoute, readFloorPlan } from './service-map-data.js';
import { createFlatMap } from './service-map-flat.js';

export default function serviceMap(service = { nama: '', langkah: [], berkas: [] }, planUrl = '') {
    let viewer = null;
    let generation = 0;
    let returnFocus = null;

    return {
        service,
        steps: service.langkah,
        activeIndex: 0,
        mode: '2D',
        status: '',
        loading: false,
        route: [],
        locations: [],
        places: [],
        init() {
            this.service = JSON.parse(this.$el.dataset.service);
            this.steps = this.service.langkah;
            planUrl = this.$el.dataset.planUrl;
        },
        get currentStep() {
            return this.steps[this.activeIndex] || {};
        },
        get currentLocation() {
            return this.route[this.activeIndex]?.location || {};
        },
        openFromEvent(event) {
            return this.openMap(event.detail?.step ?? 0);
        },
        closeFromBackdrop(event) {
            if (event.target === this.$refs.dialog) {
                this.closeMap();
            }
        },
        async openMap(index = 0) {
            if (!this.steps.length || this.$refs.dialog.open) {
                return;
            }

            returnFocus = document.activeElement;
            this.activeIndex = Math.max(0, Math.min(index, this.steps.length - 1));
            this.$refs.dialog.showModal();
            document.documentElement.classList.add('service-map-open');
            this.loading = true;
            this.status = '';
            this.route = [];
            this.locations = [];
            const request = ++generation;

            let places = [];
            try {
                const response = await fetch(planUrl);
                if (!response.ok) {
                    throw new Error('Floor plan unavailable');
                }
                places = readFloorPlan(await response.text());
                if (!places.length) {
                    throw new Error('Floor plan empty');
                }
            } catch {
                if (request === generation) {
                    this.status = 'Aset gedung belum tersedia. Urutan layanan ditampilkan secara skematis.';
                }
            }

            if (request !== generation) {
                return;
            }
            this.places = places;

            const { route, locations } = buildRoute(this.steps, this.places);
            this.route = route;
            this.locations = locations;
            await this.$nextTick();
            if (request !== generation) {
                return;
            }
            this.useFlatMap();

            try {
                const { createServiceScene } = await import('./service-map-scene.js');
                if (request !== generation) {
                    return;
                }
                const scene = createServiceScene(this.viewerOptions(), () => {
                    if (request === generation) {
                        this.useFlatMap();
                        this.status = 'Tampilan 2D aktif karena WebGL tidak tersedia.';
                    }
                });
                viewer?.dispose();
                viewer = scene;
                this.mode = '3D';
                viewer.select(this.activeIndex, false);
            } catch {
                if (request === generation) {
                    this.status = 'Tampilan 2D aktif karena WebGL tidak tersedia.';
                }
            } finally {
                if (request === generation) {
                    this.loading = false;
                }
            }
        },
        viewerOptions() {
            return {
                host: this.$refs.canvas,
                pins: this.$refs.pins,
                places: this.places,
                locations: this.locations,
                route: this.route,
            };
        },
        useFlatMap() {
            viewer?.dispose();
            viewer = createFlatMap(this.viewerOptions());
            this.mode = '2D';
            viewer.select(this.activeIndex, false);
        },
        selectStep(index) {
            if (index < 0 || index >= this.steps.length) {
                return;
            }
            this.activeIndex = index;
            viewer?.select(index, true);
            this.$nextTick(() => {
                const list = this.$refs.steps;
                const button = list.querySelector(`[data-step="${index}"]`);
                list.scrollTo({
                    top: button.offsetTop - list.offsetTop - list.clientHeight / 2 + button.clientHeight / 2,
                    behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth',
                });
            });
        },
        overview() {
            viewer?.overview();
        },
        zoom(factor) {
            viewer?.zoom(factor);
        },
        closeMap() {
            this.$refs.dialog.close();
        },
        cleanup() {
            generation++;
            viewer?.dispose();
            viewer = null;
            this.loading = false;
            document.documentElement.classList.remove('service-map-open');
            returnFocus?.focus({ preventScroll: true });
        },
        destroy() {
            this.cleanup();
        },
    };
}
