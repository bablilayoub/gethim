// Change Theme
function changeTheme() {
    const theme = document.getElementById("theme_select").value;
    document.documentElement.setAttribute("data-theme", theme);
    localStorage.setItem("theme", theme);
}

// Get the theme from the local storage
const theme = localStorage.getItem("theme");
if (theme) {
    document.getElementById("theme_select").value = theme;
    changeTheme();
}

function copyToClipboard(url) {
    navigator.clipboard.writeText(url).then(() => {
        // Create a toast
        const toast = document.createElement("div");
        toast.classList.add("toast", "toast-start");
        toast.id = "toast";

        // Create a toast alert
        const toastAlert = document.createElement("div");
        toastAlert.classList.add("alert", "alert-success");
        toastAlert.textContent = "Copied to clipboard successfully!";

        // Append the alert to the toast
        toast.appendChild(toastAlert);

        // Append the toast to the body
        document.body.appendChild(toast);

        // Keep updaing the opacity of the toast to create a fade out effect
        setTimeout(() => {
            let opacity = 1;
            const interval = setInterval(() => {
                opacity -= 0.1;
                toast.style.opacity = opacity;
                if (opacity <= 0) {
                    clearInterval(interval);
                    toast.style.display = "none";
                }
            }, 10);
        }, 3000);
    });
}

// Delete link
function deleteLink(token) {
    // Get modal
    const modal = document.getElementById("delete_link_modal");

    // Get the delete button
    const deleteLink = document.getElementById("delete_link");

    // Show the modal
    modal.showModal();

    // Add an event listener to the delete button
    deleteLink.onclick = (async () => {
        // Send a POST request to the server
        const response = await fetch("/delete", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({
                token: token,
            }),
        });

        // Check if the response is not OK
        if (!response.ok) {
            // Create a toast
            const toast = document.createElement("div");
            toast.classList.add("toast", "toast-start");
            toast.id = "toast";

            // Create a toast alert
            const toastAlert = document.createElement("div");
            toastAlert.classList.add("alert", "alert-error");
            toastAlert.textContent = "An error occurred while deleting the link";

            // Append the alert to the toast
            toast.appendChild(toastAlert);

            // Append the toast to the body
            document.body.appendChild(toast);
            modal.close();
            return;
        }

        // Get the response
        const data = await response.json();

        // Check if there is an error
        if (data.status === "error") {
            // Create a toast
            const toast = document.createElement("div");
            toast.classList.add("toast", "toast-start");
            toast.id = "toast";
            // Create a toast alert
            const toastAlert = document.createElement("div");
            toastAlert.classList.add("alert", "alert-error");
            toastAlert.textContent = data.message;
            // Append the alert to the toast
            toast.appendChild(toastAlert);
            // Append the toast to the body
            document.body.appendChild(toast);
            modal.close();
            return;
        }

        // Create a toast
        const toast = document.createElement("div");
        toast.classList.add("toast", "toast-start");
        toast.id = "toast";

        // Create a toast alert
        const toastAlert = document.createElement("div");
        toastAlert.classList.add("alert", "alert-success");
        toastAlert.textContent = "Link deleted successfully!";

        // Append the alert to the toast
        toast.appendChild(toastAlert);

        // Append the toast to the body
        document.body.appendChild(toast);

        // Get the link
        const link = document.getElementById("link_" + token);

        // Remove the link
        link.remove();

        // Close the modal
        modal.close();

        // Check if there are no links
        if (!document.getElementById("links_table").children.length) {
            // Reload the page
            location.reload();
        }
    });
}

// View Stats
async function viewStats(token) {
    // Get the modal
    const modal = document.getElementById("view_stats_modal");

    // Get no stats alert
    const noStats = document.getElementById("no_stats");

    // Get stats table
    const statsTable = document.getElementById("stats_table");

    // Hide the no stats alert
    noStats.classList.add("hidden");

    // Hide the stats table
    statsTable.classList.add("hidden");

    // Show the modal
    modal.showModal();

    // Send a POST request to the server
    const response = await fetch("/stats", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            token: token,
        }),
    });

    // Check if the response is not OK
    if (!response.ok) {
        // Create a toast
        const toast = document.createElement("div");
        toast.classList.add("toast", "toast-start");
        toast.id = "toast";

        // Create a toast alert
        const toastAlert = document.createElement("div");
        toastAlert.classList.add("alert", "alert-error");
        toastAlert.textContent = "An error occurred while fetching the stats";

        // Append the alert to the toast
        toast.appendChild(toastAlert);

        // Append the toast to the body
        document.body.appendChild(toast);
        modal.close();
        return;
    }

    // Get the response
    const data = await response.json();

    // Check if there is an error
    if (data.status === "error") {
        // Create a toast
        const toast = document.createElement("div");
        toast.classList.add("toast", "toast-start");
        toast.id = "toast";

        // Create a toast alert
        const toastAlert = document.createElement("div");
        toastAlert.classList.add("alert", "alert-error");
        toastAlert.textContent = data.message;

        // Append the alert to the toast
        toast.appendChild(toastAlert);

        // Append the toast to the body
        document.body.appendChild(toast);
        modal.close();
        return;
    }

    // Get the stats
    const stats = data.stats;

    // Check if there are no stats
    if (stats.length === 0) {
        // Show the no stats alert
        noStats.classList.remove("hidden");
        return;
    }

    // Show the stats table
    statsTable.classList.remove("hidden");

    // Get the table
    const analytics_table = document.getElementById("analytics_table");

    // Clear the table
    analytics_table.innerHTML = "";

    // for each stat
    stats.forEach((stat) => {
        // Create a row
        const row = document.createElement("tr");

        // Create a cell for the ip address
        const ip_address = document.createElement("td");
        ip_address.textContent = stat.ip_address;

        // Create a cell for the user agent
        const user_agent = document.createElement("td");
        user_agent.textContent = stat.user_agent;

        // Create a cell for date
        const date = document.createElement("td");
        const dateObj = new Date(stat.created_at);
        date.textContent = dateObj.toDateString() + " " + dateObj.toLocaleTimeString();

        // Create a cell for the location button
        const location = document.createElement("td");
        const locationButton = document.createElement("button");
        locationButton.textContent = "Location";
        locationButton.classList.add("btn", "btn-primary", "btn-sm");
        locationButton.onclick = () => {
            window.open("https://www.google.com/maps/search/?api=1&query=" + stat.latitude + "," + stat.longitude);
        };

        // Append the location button to the location cell
        location.appendChild(locationButton);

        // Append the cells to the row
        row.appendChild(ip_address);
        row.appendChild(user_agent);
        row.appendChild(date);
        row.appendChild(location);

        // Append the row to the table
        analytics_table.appendChild(row);
    });
}

// Close the toast after 3 seconds if it's open with a fade out animation
const toast = document.getElementById("toast");

if (toast) {
    setTimeout(() => {
        // Keep updaing the opacity of the toast to create a fade out effect
        let opacity = 1;
        const interval = setInterval(() => {
            opacity -= 0.1;
            toast.style.opacity = opacity;
            if (opacity <= 0) {
                clearInterval(interval);
                toast.style.display = "none";
            }
        }, 10);
    }, 3000);
}

// Shorten URL
const shorten = document.getElementById("shorten");
const url = document.getElementById("url");
const error_container = document.getElementById("error_container");
const error_message = document.getElementById("error_message");
const success_container = document.getElementById("success_container");
const success_message = document.getElementById("success_message");
const short_another = document.getElementById("short_another");

if (shorten) {
    const validURL = (str) => {
        // must start with http:// or https://
        const pattern = new RegExp(
            "^(https?:\\/\\/)?" + // protocol
            "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,})" + // domain name
            "(:\\d{1,5})?" + // port
            "(/[-a-z\\d%_.~+]*)*" + // path
            "(\\?[;&a-z\\d%_.~+=-]*)?" + // query string
            "(\\#[-a-z\\d_]*)?$",
            "i"
        ); // fragment locator
        return !!pattern.test(str);
    };

    // Shorten URL
    shorten.addEventListener("click", async () => {
        success_container.classList.add("hidden");
        error_container.classList.add("hidden");

        if (document.getElementById("copy")) {
            document.getElementById("copy").remove();
        }

        shorten.textContent = "Shortening...";
        shorten.disabled = true;
        // if input is empty
        if (!url.value) {
            error_container.classList.remove("hidden");
            error_message.textContent = "URL input cannot be empty";
            shorten.textContent = "Shorten";
            shorten.disabled = false;
            return;
        }

        // Check if the URL is empty
        if (!validURL(url.value)) {
            error_container.classList.remove("hidden");
            error_message.textContent = "Invalid URL";
            shorten.textContent = "Shorten";
            shorten.disabled = false;
            return;
        }

        // Send a POST request to the server
        const response = await fetch("/shorten", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({
                url: url.value,
            }),
        });

        // Check if the response is not OK
        if (!response.ok) {
            success_container.classList.add("hidden");
            error_container.classList.remove("hidden");
            error_message.textContent =
                "An error occurred while shortening the URL";
            shorten.textContent = "Shorten";
            shorten.disabled = false;
            return;
        }

        // Get the response
        const data = await response.json();
        // Check if there is an error
        if (data.status === "error") {
            error_container.classList.remove("hidden");
            error_message.textContent = data.message;
            shorten.textContent = "Shorten";
            shorten.disabled = false;
            return;
        }

        // Show the success message
        success_container.classList.remove("hidden");
        success_message.textContent = data.message;
        url.value = data.shortened_url;
        // readonly url
        url.setAttribute("readonly", true);
        // create copy button
        const copy = document.createElement("button");
        copy.textContent = "Copy";
        copy.id = "copy";
        copy.classList.add("btn", "btn-success", "join-item");
        // add event listener to copy button
        copy.addEventListener("click", () => {
            navigator.clipboard.writeText(url.value).then(() => {
                copy.textContent = "Copied!";
                setTimeout(() => {
                    copy.textContent = "Copy";
                }, 3000);
            });
        });
        // append copy button
        document.getElementById("shorten_url").appendChild(copy);
        short_another.classList.remove("hidden");
        shorten.textContent = "Shorten";
        shorten.classList.add("hidden");
        shorten.classList.remove("join-item");
    });
}
