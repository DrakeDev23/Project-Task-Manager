document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    if (!calendarEl) return;

    const modal = document.getElementById('taskModal');
    const title = document.getElementById('taskModalTitle');
    const status = document.getElementById('taskModalStatus');
    const priority = document.getElementById('taskModalPriority');
    const dueDate = document.getElementById('taskModalDate');
    const description = document.getElementById('taskModalDescription');
    const link = document.getElementById('taskModalLink');

    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    };

    document.getElementById('closeTaskModal').addEventListener('click', closeModal);
    document.getElementById('closeTaskModalButton').addEventListener('click', closeModal);
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    const calendarEvents = JSON.parse(calendarEl.dataset.events || '[]');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listMonth'
        },
        buttonText: {
            today: 'Today',
            month: 'Month',
            list: 'List'
        },
        events: calendarEvents,
        eventDisplay: 'block',
        displayEventTime: false,
        eventClick: function (info) {
            const props = info.event.extendedProps;
            const taskUrl = props.taskUrl || '#';

            title.textContent = info.event.title;
            status.textContent = (props.status || 'Unknown').replace('_', ' ');
            priority.textContent = (props.priority || 'Unknown');
            dueDate.textContent = props.dueDate || info.event.start?.toLocaleDateString() || 'No date';
            description.textContent = props.description || 'No description provided.';
            link.href = taskUrl;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        },
        eventDidMount: function (info) {
            info.el.title = info.event.title;
        },
        locale: 'en',
        contentHeight: 680,
        stickyHeaderDates: true,
    });

    calendar.render();
});