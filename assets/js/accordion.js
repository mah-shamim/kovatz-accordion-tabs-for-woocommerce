document.addEventListener("DOMContentLoaded", function() {

    let items = Array.from(document.querySelectorAll(".kovatz-accordion-item"));
    let desktopTabs = Array.from(document.querySelectorAll(".kovatz-tab-button"));
    let mobileButtons = Array.from(document.querySelectorAll(".kovatz-accordion-button"));
    let mobileLayout = window.matchMedia("(max-width: 767px)");

    function syncLayout() {
        if (!mobileLayout.matches) {
            let activeItem = items.find(function(item) {
                return item.classList.contains("kovatz-active");
            }) || items[0];

            items.forEach(function(item) {
                item.classList.toggle("kovatz-active", item === activeItem);
                let panel = item.querySelector(".kovatz-accordion-body");
                if (panel) panel.style.maxHeight = null;
            });
        } else {
            items.forEach(function(item) {
                let panel = item.querySelector(".kovatz-accordion-body");
                if (panel) {
                    panel.style.maxHeight = item.classList.contains("kovatz-active")
                        ? panel.scrollHeight + "px"
                        : null;
                }
            });
        }

        items.forEach(function(item) {
            let target = "#" + item.querySelector(".kovatz-accordion-body").id;
            let isActive = item.classList.contains("kovatz-active");
            let desktopTab = desktopTabs.find(function(tab) {
                return tab.getAttribute("data-target") === target;
            });
            let mobileButton = mobileButtons.find(function(button) {
                return button.getAttribute("data-target") === target;
            });

            if (desktopTab) {
                desktopTab.classList.toggle("kovatz-active", isActive);
                desktopTab.setAttribute("aria-selected", isActive ? "true" : "false");
                desktopTab.setAttribute("tabindex", isActive ? "0" : "-1");
            }
            if (mobileButton) mobileButton.setAttribute("aria-expanded", isActive ? "true" : "false");
        });
    }

    desktopTabs.forEach(function(tab) {
        tab.addEventListener("click", function() {
            let target = this.getAttribute("data-target");
            items.forEach(function(item) {
                let panel = item.querySelector(".kovatz-accordion-body");
                item.classList.toggle("kovatz-active", panel && "#" + panel.id === target);
            });
            syncLayout();
        });

        tab.addEventListener("keydown", function(event) {
            let currentIndex = desktopTabs.indexOf(this);
            let nextIndex;

            if (event.key === "ArrowRight") {
                nextIndex = (currentIndex + 1) % desktopTabs.length;
            } else if (event.key === "ArrowLeft") {
                nextIndex = (currentIndex - 1 + desktopTabs.length) % desktopTabs.length;
            } else if (event.key === "Home") {
                nextIndex = 0;
            } else if (event.key === "End") {
                nextIndex = desktopTabs.length - 1;
            } else {
                return;
            }

            event.preventDefault();
            desktopTabs[nextIndex].focus();
            desktopTabs[nextIndex].click();
        });
    });

    mobileButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            if (kovatz_accordion.accordion_type === "one") {
                let currentItem = this.closest(".kovatz-accordion-item");
                let wasActive = currentItem.classList.contains("kovatz-active");
                items.forEach(function(item) {
                    item.classList.toggle("kovatz-active", !wasActive && item === currentItem);
                });
            } else {
                this.closest(".kovatz-accordion-item").classList.toggle("kovatz-active");
            }
            syncLayout();
        });
    });

    if (mobileLayout.addEventListener) {
        mobileLayout.addEventListener("change", syncLayout);
    } else {
        mobileLayout.addListener(syncLayout);
    }
    syncLayout();
});
