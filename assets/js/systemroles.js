const toggleSidebar = document.getElementById("toggleSidebar");
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.getElementById("mainContent");

        // Collapse sidebar
        toggleSidebar.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            mainContent.classList.toggle("collapsed");

            // Close all open submenus when sidebar is collapsed
            if (sidebar.classList.contains("collapsed")) {
                document.querySelectorAll(".menu-item.open").forEach((item) => {
                    item.classList.remove("open");
                    const toggleIcon = item.querySelector(".toggle-icon");
                    if (toggleIcon) toggleIcon.classList.remove("ri-rotate-180");
                });
            }
        });

        // Handle menu toggles
        document.querySelectorAll(".menu-toggle").forEach((item) => {
            item.addEventListener("click", function (e) {
                // Prevent action if sidebar is collapsed
                if (sidebar.classList.contains("collapsed")) {
                    e.preventDefault();
                    return;
                }

                e.preventDefault();
                const parent = this.closest(".menu-item");
                parent.classList.toggle("open");

                // Toggle arrow icon
                const toggleIcon = this.querySelector(".toggle-icon");
                if (toggleIcon) {
                    toggleIcon.classList.toggle("ri-rotate-180");
                }
            });
        });