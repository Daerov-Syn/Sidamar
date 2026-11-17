// Coordinates and room names are read from the project's existing floor-plan asset.
export function readFloorPlan(markup) {
    const document = new DOMParser().parseFromString(markup, 'text/html');

    return [...document.querySelectorAll('#plan .place')].map((element) => {
        const rectangle = element.querySelector('.top');
        const coordinates = element.getAttribute('transform').match(/translate\(([\d.]+)[ ,]+([\d.]+)\)/);

        return {
            id: element.dataset.id,
            name: element.getAttribute('aria-label'),
            x: Number(coordinates[1]) / 100,
            z: Number(coordinates[2]) / 100,
            width: Number(rectangle.getAttribute('width')) / 100,
            depth: Number(rectangle.getAttribute('height')) / 100,
        };
    });
}

export function locateStep(step, places) {
    const code = (step.kode_loket || '').trim().toUpperCase();
    if (code === 'CF' || code === 'FISIK') {
        const physicalAreas = places.filter((place) => ['1', '2'].includes(place.id));
        if (physicalAreas.length === 2) {
            const x = Math.min(...physicalAreas.map((place) => place.x));
            const z = Math.min(...physicalAreas.map((place) => place.z));
            return {
                id: 'physical-areas',
                placeIds: physicalAreas.map((place) => place.id),
                name: 'Area Cek Fisik Roda 2 / Roda 4',
                x,
                z,
                width: Math.max(...physicalAreas.map((place) => place.x + place.width)) - x,
                depth: Math.max(...physicalAreas.map((place) => place.z + place.depth)) - z,
            };
        }
    }
    // Only unambiguous correspondences present in the supplied plan are mapped.
    const locationIds = { KAS: '9', KSR: '9', FISKAL: '14', FORM: '28' };
    let locationId = locationIds[code];

    if (code === 'P' && /STNK/.test(step.teks) && !/BPKB/.test(step.teks)) {
        locationId = '7';
    }

    return places.find((place) => place.id === locationId) || null;
}

export function buildRoute(steps, places) {
    const locations = new Map();
    let unplacedCount = 0;
    const route = steps.map((step, index) => {
        const place = locateStep(step, places);
        const code = (step.kode_loket || '').trim().toUpperCase();
        const key = place ? `place-${place.id}` : `unplaced-${code || index}`;

        if (!locations.has(key)) {
            locations.set(key, {
                key,
                placeId: place?.id,
                placeIds: place?.placeIds || [],
                name: place?.name || step.teks,
                x: place ? place.x + place.width / 2 : 2 + unplacedCount++ * 2.8,
                z: place ? place.z + place.depth / 2 : 8,
                mapped: Boolean(place),
                steps: [],
            });
        }

        const location = locations.get(key);
        location.steps.push(index);

        return { ...step, index, location };
    });

    return { route, locations: [...locations.values()] };
}
