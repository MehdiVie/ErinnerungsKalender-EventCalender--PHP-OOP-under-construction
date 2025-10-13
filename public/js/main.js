document.addEventListener("DOMContentLoaded", () => {
  console.log("main.js loaded ✅");
  console.log("BASE_URL =", BASE_URL);


  function getOrCreateAlertContainer() {
    let container = document.getElementById("alert-container");
    if (!container) {
      container = document.createElement("div");
      container.id = "alert-container";
      container.className = "position-fixed top-0 start-50 translate-middle-x mt-5";
      container.style.zIndex = "2000";
      container.style.width = "90%";
      container.style.maxWidth = "600px";
      document.body.prepend(container);
    }
    return container;
  }


  function showAlert(message, type = "success") {
    const container = getOrCreateAlertContainer();

    const alertDiv = document.createElement("div");
    alertDiv.className = `alert alert-${type} alert-dismissible fade show shadow`;
    alertDiv.role = "alert";
    alertDiv.innerHTML = `
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    container.appendChild(alertDiv);

    setTimeout(() => {
      alertDiv.classList.remove("show");
      alertDiv.classList.add("fade");
      alertDiv.addEventListener("transitionend", () => alertDiv.remove());
    }, 3500);
  }


  document.querySelectorAll(".delete-btn").forEach((btn) => {
    btn.addEventListener("click", async (e) => {
      const tr = e.target.closest("tr, .card");
      const id = tr?.dataset?.id;

      if (!id) {
        showAlert("Event-ID fehlt!", "danger");
        return;
      }

      if (!confirm("Willst du wirklich löschen?")) return;

      const formData = new FormData();
      formData.append("action", "delete");
      formData.append("id", id);

      try {
        const res = await fetch(`${BASE_URL}/ajax/ajax_events.php`, {
          method: "POST",
          body: formData,
        });

        if (!res.ok) throw new Error(`Server returned ${res.status}`);

        const data = await res.json();
        console.log("Response:", data);

        if (data.success) {
          tr.remove();
          showAlert("Bezeichnung erfolgreich gelöscht."); 
        } else {
          showAlert(data.errors ? data.errors.join("<br>") : "Fehler beim Löschen!", "danger");
        }
      } catch (error) {
        console.error("AJAX-Fehler:", error);
        showAlert("Verbindung zum Server fehlgeschlagen!", "danger");
      }
    });
  });


  document.querySelectorAll(".edit-btn").forEach((btn) => {
    btn.addEventListener("click", async (e) => {
      const tr = e.target.closest("tr, .card");
      const id = tr?.dataset?.id;
      if (!id) return;

      try {
        const formData = new FormData();
        formData.append("action", "get");
        formData.append("id", id);

        const res = await fetch(`${BASE_URL}/ajax/ajax_events.php`, {
          method: "POST",
          body: formData,
        });
        const data = await res.json();

        if (data && data.id) {

          //const form = document.getElementById("editForm");
          //form.reset();

          document.getElementById("edit-id").value = data.id;
          document.getElementById("edit-title").value = data.title || "";
          document.getElementById("edit-date").value = data.event_date || "";
          document.getElementById("edit-reminder").value = data.reminder_time_input || "";

          const modal = new bootstrap.Modal(document.getElementById("editModal"));
          modal.show();
        } else {
          showAlert("Fehler beim Laden der Eventdaten!", "danger");
        }
      } catch (err) {
        console.error("Fehler beim Laden:", err);
        showAlert("Fehler beim Laden der Daten!", "danger");
      }
    });
  });


  const editForm = document.getElementById("editForm");
  if (editForm) {
    editForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const fd = new FormData(e.target);
      fd.append("action", "update");

      try {
        const res = await fetch(`${BASE_URL}/ajax/ajax_events.php`, {
          method: "POST",
          body: fd,
        });
        const text = await res.text();

        if (!text.trim()) {
          showAlert("Serverfehler – leere Antwort erhalten.", "danger");
          return;
        }

        let data;
        try {
          data = JSON.parse(text);
        } catch (err) {
          console.error("Ungültige JSON-Antwort:", text);
          showAlert("Ungültige Server-Antwort erhalten!", "danger");
          return;
        }

        console.log("Server Response:", data);

        if (data.success) {
          showAlert("Bezeichnung erfolgreich bearbeitet.");
          setTimeout(() => location.reload(), 1000);
        } else if (Array.isArray(data.errors) && data.errors.length > 0) {
          showAlert(data.errors.join("<br>"), "danger");
        } else {
          showAlert("Fehler beim Aktualisieren!", "danger");
        }
      } catch (error) {
        console.error("AJAX Fehler:", error);
        showAlert("Verbindung zum Server fehlgeschlagen!", "danger");
      }
    });
  }
});
