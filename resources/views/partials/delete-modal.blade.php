{{-- Reusable delete confirmation modal. Opened via [data-delete-trigger]. --}}
<div
    id="deleteModal"
    class="fixed inset-0 z-50 hidden items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="deleteModalTitle"
    aria-describedby="deleteModalMessage"
    aria-hidden="true"
>
    <div data-delete-backdrop class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px] opacity-0 transition-opacity duration-200"></div>

    <div
        data-delete-panel
        class="relative w-full max-w-md scale-95 rounded-2xl bg-white p-6 shadow-xl ring-1 ring-slate-200 opacity-0 transition duration-200"
    >
        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-rose-50 text-rose-600">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V6m2 0v13.5A1.5 1.5 0 0 1 16.5 21h-9A1.5 1.5 0 0 1 6 19.5V6m3 4.5v6m6-6v6" />
            </svg>
        </div>

        <h2 id="deleteModalTitle" class="mt-4 text-lg font-semibold text-slate-900">Delete item?</h2>
        <p id="deleteModalMessage" class="mt-2 text-sm leading-6 text-slate-500">
            This action cannot be undone.
        </p>

        <div class="mt-6 flex flex-wrap justify-end gap-3">
            <button
                type="button"
                data-delete-cancel
                class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
            >
                Cancel
            </button>
            <button
                type="button"
                data-delete-confirm
                class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-700"
            >
                Delete
            </button>
        </div>
    </div>
</div>
