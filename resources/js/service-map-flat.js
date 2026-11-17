export function createFlatMap({ host, pins, places, locations, route }) {
    const canvas = document.createElement('canvas');
    canvas.setAttribute('aria-hidden', 'true');
    host.append(canvas);
    const context = canvas.getContext('2d');
    const worldWidth = Math.max(22.5, ...locations.map((location) => location.x + 2));
    let activeIndex = 0;
    let zoom = 1;
    let center = { x: worldWidth / 2, z: 4.5 };

    function draw() {
        const width = host.clientWidth;
        const height = host.clientHeight;
        const ratio = Math.min(devicePixelRatio || 1, 1.5);
        canvas.width = width * ratio;
        canvas.height = height * ratio;
        canvas.style.width = `${width}px`;
        canvas.style.height = `${height}px`;
        context.setTransform(ratio, 0, 0, ratio, 0, 0);
        context.fillStyle = '#edf5fc';
        context.fillRect(0, 0, width, height);
        const scale = Math.min(width / worldWidth, height / 10) * zoom;
        const project = (x, z) => [width / 2 + (x - center.x) * scale, height / 2 + (z - center.z) * scale];

        function rectangle(x, z, w, d, color, border = '#c3d8eb') {
            const [left, top] = project(x, z);
            context.fillStyle = color;
            context.fillRect(left, top, w * scale, d * scale);
            context.strokeStyle = border;
            context.lineWidth = 1;
            context.strokeRect(left, top, w * scale, d * scale);
        }

        function label(text, x, z, color = '#526c87') {
            const [left, top] = project(x, z);
            context.font = '600 12px Inter, sans-serif';
            context.textAlign = 'center';
            context.fillStyle = color;
            context.fillText(text, left, top);
        }

        if (places.length) {
            rectangle(0.36, 1.08, 17.08, 3.5, '#ffffff');
            label('GEDUNG PELAYANAN', 8.8, 0.65);
            label('AREA LUAR', 20, 0.65);
            label('Pintu masuk ↑', 8.75, 5.2, '#0b4da2');
            label('Pintu keluar ↓', 6.3, 5.2);
            places.forEach((place) => {
                const location = route[activeIndex]?.location;
                const active = location?.placeId === place.id || location?.placeIds.includes(place.id);
                rectangle(place.x, place.z, place.width, place.depth, active ? '#1677ff' : '#e0edf8');
                label(place.id, place.x + place.width / 2, place.z + place.depth / 2, active ? '#ffffff' : '#526c87');
            });
        }

        if (locations.some((location) => !location.mapped)) {
            label('TAHAP TANPA POSISI PADA ASET', worldWidth / 2, 6.8);
        }

        route.slice(1).forEach((step, index) => {
            const from = route[index].location;
            const to = step.location;
            const [startX, startY] = project(from.x, from.z);
            const [endX, endY] = project(to.x, to.z);
            const angle = Math.atan2(endY - startY, endX - startX);
            const isActive = index + 1 === activeIndex;
            context.strokeStyle = isActive ? '#1677ff' : '#7ca9d6';
            context.fillStyle = context.strokeStyle;
            context.lineWidth = isActive ? 3 : 1.5;
            context.beginPath();
            if (from === to) {
                context.arc(startX + 20, startY - 25, 22, 0.8, 5.8);
            } else {
                context.moveTo(startX, startY);
                context.lineTo(endX, endY);
            }
            context.stroke();
            const arrowX = startX + (endX - startX) * 0.65;
            const arrowY = startY + (endY - startY) * 0.65;
            context.beginPath();
            context.moveTo(arrowX, arrowY);
            context.lineTo(arrowX - 10 * Math.cos(angle - 0.5), arrowY - 10 * Math.sin(angle - 0.5));
            context.lineTo(arrowX - 10 * Math.cos(angle + 0.5), arrowY - 10 * Math.sin(angle + 0.5));
            context.closePath();
            context.fill();
        });

        locations.forEach((location, index) => {
            const pin = pins.querySelectorAll('[data-map-pin]')[index];
            const [left, top] = project(location.x, location.z);
            pin.style.transform = `translate(${left}px, ${top}px) translate(-50%, -50%)`;
            pin.hidden = left < 0 || left > width || top < 0 || top > height;
        });
    }

    const observer = new ResizeObserver(draw);
    observer.observe(host);
    draw();

    return {
        select(index, focus) {
            activeIndex = index;
            if (focus) {
                center = route[index].location;
                zoom = host.clientWidth < 600 ? 2.8 : 1.7;
            }
            draw();
        },
        overview() {
            center = { x: worldWidth / 2, z: 4.5 };
            zoom = 1;
            draw();
        },
        zoom(factor) {
            zoom = Math.max(1, Math.min(4, zoom * factor));
            draw();
        },
        dispose() {
            observer.disconnect();
            canvas.remove();
        },
    };
}
