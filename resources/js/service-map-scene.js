import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

export function createServiceScene({ host, pins, places, locations, route }, onContextLost) {
    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'low-power' });
    renderer.setPixelRatio(Math.min(devicePixelRatio || 1, 1.5));
    renderer.setClearColor('#edf5fc');
    renderer.domElement.setAttribute('aria-hidden', 'true');
    host.append(renderer.domElement);

    const scene = new THREE.Scene();
    const camera = new THREE.OrthographicCamera(-14, 14, 7, -7, 0.1, 100);
    const worldWidth = Math.max(22.5, ...locations.map((location) => location.x + 2));
    const center = new THREE.Vector3(worldWidth / 2, 0, 4.5);
    const cameraOffset = new THREE.Vector3(2.5, 18, 16);
    camera.position.copy(center).add(cameraOffset);
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.target.copy(center);
    controls.enablePan = false;
    controls.minPolarAngle = Math.PI / 6;
    controls.maxPolarAngle = Math.PI / 2.6;
    controls.minAzimuthAngle = -Math.PI / 8;
    controls.maxAzimuthAngle = Math.PI / 8;
    controls.minZoom = 1;
    controls.maxZoom = 5;
    controls.update();

    scene.add(new THREE.HemisphereLight(0xffffff, 0x7f9bb7, 2.6));
    const sunlight = new THREE.DirectionalLight(0xffffff, 2.2);
    sunlight.position.set(-3, 15, 8);
    scene.add(sunlight);

    const materials = new Map();
    function material(color) {
        if (!materials.has(color)) {
            materials.set(color, new THREE.MeshLambertMaterial({ color }));
        }
        return materials.get(color);
    }

    function box(x, z, width, depth, height, color, elevation = 0) {
        const mesh = new THREE.Mesh(new THREE.BoxGeometry(width, height, depth), material(color));
        mesh.position.set(x + width / 2, elevation + height / 2, z + depth / 2);
        scene.add(mesh);
        return mesh;
    }

    function sign(text, x, z, width, fontSize = 28) {
        const canvas = document.createElement('canvas');
        canvas.width = 512;
        canvas.height = 80;
        const context = canvas.getContext('2d');
        context.fillStyle = '#345574';
        context.font = `600 ${fontSize}px sans-serif`;
        context.textAlign = 'center';
        context.textBaseline = 'middle';
        context.fillText(text, 256, 40);
        const texture = new THREE.CanvasTexture(canvas);
        const sprite = new THREE.Sprite(new THREE.SpriteMaterial({ map: texture, depthTest: false }));
        sprite.position.set(x, 0.8, z);
        sprite.scale.set(width, width * 80 / 512, 1);
        scene.add(sprite);
    }

    const counterMeshes = new Map();
    if (places.length) {
        box(0.26, 0.99, 17.58, 3.72, 0.18, '#c5d9ec', -0.18);
        box(0.36, 1.08, 17.08, 3.5, 0.04, '#ffffff');
        box(0.30, 1.02, 17.2, 0.08, 0.85, '#d5e5f3');
        box(0.30, 1.02, 0.08, 3.5, 0.85, '#dae8f4');
        box(17.44, 1.02, 0.08, 3.5, 0.85, '#dae8f4');
        // The two front-wall openings retain the entrance and exit from the asset.
        [[0.36, 5.45], [6.81, 1.41], [9.37, 8.07]].forEach(([x, width]) => {
            box(x, 4.51, width, 0.07, 0.22, '#b8d1e8');
        });
        box(8.22, 4.5, 1.15, 0.65, 0.025, '#80b9ed');
        sign('PINTU MASUK', 8.75, 5.35, 2.1);
        sign('PINTU KELUAR', 6.3, 5.35, 2.1);
        sign('GEDUNG PELAYANAN', 8.8, 0.35, 4.7);
        sign('AREA LUAR', 20, 0.35, 3);

        places.forEach((place) => {
            const mesh = box(place.x, place.z, place.width, place.depth, 0.55, '#d9e8f5');
            counterMeshes.set(place.id, mesh);
            box(place.x, place.z, place.width, 0.08, 0.58, '#bdd6ec');
            sign(place.id, place.x + place.width / 2, place.z + place.depth / 2, 2.8, 64);
        });
        // Seating coordinates come from the bench instances in the same floor-plan asset.
        [[2.75, 2.79], [3.5, 2.79], [11.1, 2.79], [11.85, 2.79]].forEach(([x, z]) => {
            box(x, z, 0.62, 0.20, 0.18, '#c3d9eb');
            box(x, z, 0.62, 0.05, 0.35, '#b1cee6');
        });
    }

    if (locations.some((location) => !location.mapped)) {
        sign('TAHAP TANPA POSISI PADA ASET', worldWidth / 2, 6.65, 7);
    }
    const schematicMeshes = new Map();
    locations.filter((location) => !location.mapped).forEach((location) => {
        schematicMeshes.set(location.key, box(location.x - 0.5, location.z - 0.35, 1, 0.7, 0.12, '#d2e3f3'));
    });

    const connections = route.slice(1).map((step, index) => {
        const from = route[index].location;
        const to = step.location;
        const start = new THREE.Vector3(from.x, 0.95, from.z);
        const end = new THREE.Vector3(to.x, 0.95, to.z);
        const group = new THREE.Group();
        const direction = end.clone().sub(start);

        if (direction.length() < 0.01) {
            const points = new THREE.EllipseCurve(start.x + 0.35, start.z, 0.5, 0.45, 0, Math.PI * 1.8).getPoints(24);
            const geometry = new THREE.BufferGeometry().setFromPoints(points.map((point) => new THREE.Vector3(point.x, 0.95, point.y)));
            group.add(new THREE.Line(geometry, new THREE.LineBasicMaterial({ color: '#8aaed0' })));
            group.add(new THREE.ArrowHelper(new THREE.Vector3(0, 0, 1), start.clone().add(new THREE.Vector3(0.85, 0, 0)), 0.35, '#8aaed0', 0.22, 0.16));
        } else {
            group.add(new THREE.Line(new THREE.BufferGeometry().setFromPoints([start, end]), new THREE.LineBasicMaterial({ color: '#8aaed0' })));
            group.add(new THREE.ArrowHelper(direction.clone().normalize(), start.clone().lerp(end, 0.6), Math.min(direction.length() * 0.2, 0.65), '#8aaed0', 0.25, 0.18));
        }
        scene.add(group);
        return group;
    });

    let frame = 0;
    let disposed = false;
    let transition = null;
    let activeIndex = 0;
    const projected = new THREE.Vector3();

    function render() {
        if (disposed) {
            return;
        }
        renderer.render(scene, camera);
        locations.forEach((location, index) => {
            projected.set(location.x, 1.15, location.z).project(camera);
            const pin = pins.querySelectorAll('[data-map-pin]')[index];
            const left = (projected.x + 1) * host.clientWidth / 2;
            const top = (1 - projected.y) * host.clientHeight / 2;
            pin.style.transform = `translate(${left}px, ${top}px) translate(-50%, -50%)`;
            pin.hidden = Math.abs(projected.x) > 1 || Math.abs(projected.y) > 1 || projected.z > 1;
        });
    }

    function stopTransition() {
        cancelAnimationFrame(frame);
        transition = null;
    }

    function moveTo(target, zoom, animate) {
        stopTransition();
        const startTarget = controls.target.clone();
        const startPosition = camera.position.clone();
        const endPosition = target.clone().add(camera.position.clone().sub(controls.target));
        const startZoom = camera.zoom;
        const duration = animate && !matchMedia('(prefers-reduced-motion: reduce)').matches ? 450 : 0;
        transition = performance.now();

        function tick(now) {
            const progress = duration ? Math.min((now - transition) / duration, 1) : 1;
            const eased = 1 - Math.pow(1 - progress, 3);
            controls.target.lerpVectors(startTarget, target, eased);
            camera.position.lerpVectors(startPosition, endPosition, eased);
            camera.zoom = startZoom + (zoom - startZoom) * eased;
            camera.updateProjectionMatrix();
            controls.update();
            render();
            if (progress < 1) {
                frame = requestAnimationFrame(tick);
            }
        }
        frame = requestAnimationFrame(tick);
    }

    function resize() {
        const width = host.clientWidth;
        const height = host.clientHeight;
        const aspect = width / Math.max(height, 1);
        const halfWidth = Math.max(worldWidth / 2 + 1, 6.2 * aspect);
        camera.left = -halfWidth;
        camera.right = halfWidth;
        camera.top = halfWidth / aspect;
        camera.bottom = -halfWidth / aspect;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
        render();
    }

    function contextLost(event) {
        event.preventDefault();
        onContextLost();
    }
    controls.addEventListener('change', render);
    controls.addEventListener('start', stopTransition);
    renderer.domElement.addEventListener('webglcontextlost', contextLost);
    const observer = new ResizeObserver(resize);
    observer.observe(host);
    resize();

    return {
        select(index, focus) {
            activeIndex = index;
            const location = route[activeIndex].location;
            counterMeshes.forEach((mesh, id) => {
                const active = id === location.placeId || location.placeIds.includes(id);
                mesh.material = material(active ? '#1677ff' : '#d9e8f5');
            });
            schematicMeshes.forEach((mesh, key) => {
                mesh.material = material(key === location.key ? '#1677ff' : '#d2e3f3');
            });
            connections.forEach((group, connectionIndex) => {
                group.traverse((child) => {
                    if (child.material?.color) {
                        child.material.color.set(connectionIndex + 1 === index ? '#1677ff' : '#8aaed0');
                    }
                });
            });
            if (focus) {
                moveTo(new THREE.Vector3(location.x, 0, location.z), host.clientWidth < 600 ? 3.2 : 2, true);
            }
            render();
        },
        overview() {
            moveTo(center, 1, true);
        },
        zoom(factor) {
            moveTo(controls.target.clone(), Math.max(1, Math.min(5, camera.zoom * factor)), true);
        },
        dispose() {
            disposed = true;
            stopTransition();
            observer.disconnect();
            controls.dispose();
            renderer.domElement.removeEventListener('webglcontextlost', contextLost);
            const geometries = new Set();
            const sceneMaterials = new Set(materials.values());
            scene.traverse((object) => {
                if (object.geometry) {
                    geometries.add(object.geometry);
                }
                if (object.material) {
                    sceneMaterials.add(object.material);
                }
            });
            geometries.forEach((geometry) => geometry.dispose());
            sceneMaterials.forEach((item) => {
                item.map?.dispose();
                item.dispose();
            });
            renderer.dispose();
            renderer.domElement.remove();
        },
    };
}
