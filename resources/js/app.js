import Alpine from '@alpinejs/csp';
import serviceMap from './service-map';
import serviceDetail from './service-detail';

window.Alpine = Alpine;
Alpine.data('serviceMap', serviceMap);
Alpine.data('serviceDetail', serviceDetail);
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        const wrap = button.closest('.auth-password-wrap');
        const input = wrap?.querySelector('input');
        const visibleIcon = button.querySelector('[data-password-visible="hide"]');
        const hiddenIcon = button.querySelector('[data-password-visible="show"]');

        if (!input || !visibleIcon || !hiddenIcon) {
            return;
        }

        button.addEventListener('click', () => {
            const isPasswordHidden = input.type === 'password';
            input.type = isPasswordHidden ? 'text' : 'password';
            button.setAttribute('aria-label', isPasswordHidden ? 'Sembunyikan password' : 'Tampilkan password');
            visibleIcon.style.display = isPasswordHidden ? 'none' : 'block';
            hiddenIcon.style.display = isPasswordHidden ? 'block' : 'none';
        });
    });
});
