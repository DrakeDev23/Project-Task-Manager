const sidebar = document.getElementById('sidebar')
const mainContent = document.getElementById('mainContent')
const sidebarToggle = document.getElementById('sidebarToggle')
const menuIcon = document.getElementById('menuIcon')
const navTexts = document.querySelectorAll('.nav-text')
const navItems = document.querySelectorAll('.nav-item')

let sidebarOpen = true

sidebarToggle?.addEventListener('click', () => {
    sidebarOpen = !sidebarOpen

    if (sidebarOpen) {
        sidebar.classList.remove('w-20')
        sidebar.classList.add('w-64')

        mainContent.classList.remove('ml-20')
        mainContent.classList.add('ml-64')

        menuIcon.classList.remove('rotate-180')

        navItems.forEach(item => {
            item.classList.remove('justify-center')
        })

        navTexts.forEach(text => {
            text.classList.remove('opacity-0', 'w-0', 'translate-x-[-8px]')
            text.classList.add('opacity-100', 'w-auto', 'translate-x-0')
        })
    } else {
        navTexts.forEach(text => {
            text.classList.remove('opacity-100', 'w-auto', 'translate-x-0')
            text.classList.add('opacity-0', 'w-0', 'translate-x-[-8px]')
        })

        navItems.forEach(item => {
            item.classList.add('justify-center')
        })

        menuIcon.classList.add('rotate-180')

        setTimeout(() => {
            sidebar.classList.remove('w-64')
            sidebar.classList.add('w-20')

            mainContent.classList.remove('ml-64')
            mainContent.classList.add('ml-20')
        }, 100)
    }
})