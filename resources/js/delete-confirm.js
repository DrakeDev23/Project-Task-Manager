function initDeleteConfirm() {
    const modal = document.getElementById('deleteModal');
    if (!modal) return;

    const backdrop = modal.querySelector('[data-delete-backdrop]');
    const panel = modal.querySelector('[data-delete-panel]');
    const titleEl = modal.querySelector('#deleteModalTitle');
    const messageEl = modal.querySelector('#deleteModalMessage');
    const cancelBtn = modal.querySelector('[data-delete-cancel]');
    const confirmBtn = modal.querySelector('[data-delete-confirm]');

    let pendingForm = null;

    function openModal(trigger) {
        pendingForm = trigger.closest('form');
        if (!pendingForm) return;

        titleEl.textContent = trigger.dataset.deleteTitle || 'Delete item?';
        messageEl.textContent = trigger.dataset.deleteMessage || 'This action cannot be undone.';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });

        confirmBtn.focus();
    }

    function closeModal() {
        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        window.setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('overflow-hidden');
            pendingForm = null;
        }, 180);
    }

    document.querySelectorAll('[data-delete-trigger]').forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            openModal(trigger);
        });
    });

    cancelBtn?.addEventListener('click', closeModal);
    backdrop?.addEventListener('click', closeModal);

    confirmBtn?.addEventListener('click', () => {
        if (pendingForm) {
            pendingForm.submit();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
}

document.addEventListener('DOMContentLoaded', initDeleteConfirm);
