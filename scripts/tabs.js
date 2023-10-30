document.addEventListener("DOMContentLoaded", () => {
    const mainTabs = document.querySelectorAll(".main-tab");
    const mainTabContents = document.querySelectorAll(".main-tab-content .tab-panel");
    const tabs = document.querySelectorAll(".tab");
    const tabContents = document.querySelectorAll(".group-content");

    // Выбираем первую главную табу и соответствующее содержимое
    const firstMainTab = mainTabs[0];
    const firstMainTabContent = document.querySelector(`.main-tab-content .tab-panel[data-tab="${firstMainTab.getAttribute("data-tab")}"]`);

    if (firstMainTab && firstMainTabContent) {
        firstMainTab.classList.add('active');
        firstMainTabContent.classList.add('active');
    }

    // Выбираем первую внутреннюю табу и соответствующее содержимое
    if (tabs && tabs.length > 0) {
        const firstTab = tabs[0];
        const firstTabContent = document.querySelector(`.group-content[data-group-id="${firstTab.getAttribute("data-group-id")}"][data-tab="${firstTab.getAttribute("data-tab")}"]`);

        if (firstTab && firstTabContent) {
            firstTab.classList.add('active');
            firstTabContent.classList.add('active');
        }
    }

    mainTabs.forEach(mainTab => {
        mainTab.addEventListener("click", () => {
            const tabId = mainTab.getAttribute("data-tab");

            mainTabContents.forEach(content => {
                content.classList.remove("active");
            });

            const activeContent = document.querySelector(`.main-tab-content .tab-panel[data-tab="${tabId}"]`);
            activeContent.classList.add('active');

            mainTabs.forEach(t => {
                t.classList.remove('active');
            });

            // Добавьте класс active к активной главной вкладке
            mainTab.classList.add('active');

            tabs.forEach(t => {
                t.classList.remove('active');
            });

            if (tabs && tabs.length > 0) {
                const firstTab = tabs[0];
                const firstTabContent = document.querySelector(`.group-content[data-group-id="${firstTab.getAttribute("data-group-id")}"][data-tab="${firstTab.getAttribute("data-tab")}"]`);

                if (firstTab && firstTabContent) {
                    firstTab.classList.add('active');
                    firstTabContent.classList.add('active');
                }
            }
        });
    });

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            const groupId = tab.getAttribute("data-group-id");
            const tabId = tab.getAttribute("data-tab");

            tabContents.forEach(content => {
                content.classList.remove("active");
            });

            // Поиск по data-group-id и data-tab
            const activeContent = document.querySelector(`.group-content[data-group-id="${groupId}"][data-tab="${tabId}"]`);
            if (activeContent) {
                activeContent.classList.add("active");
            }

            tabs.forEach(t => {
                t.classList.remove('active');
            });

            // Добавьте класс active к активной внутренней вкладке
            tab.classList.add('active');
        });
    });
});