
document.addEventListener("DOMContentLoaded", () => {
  console.log("main.js loaded ✅");
  console.log("BASE_URL =", BASE_URL);

  document.querySelectorAll(".delete-btn").forEach((btn) => {
    btn.addEventListener("click", async (e) => {
      const tr = e.target.closest("tr");
      const id = tr.dataset.id;

      if (!id) {
        alert("Event-ID fehlt!");
        return;
      }

      if (confirm("Willst du wirklich löschen?")) {
        const formData = new FormData();
        formData.append("action", "delete");
        formData.append("id", id);

        try {
          const res = await fetch(`${BASE_URL}/ajax/ajax_events.php`, {
            method: "POST",
            body: formData,
          });

          if (!res.ok) {
            throw new Error(`Server returned ${res.status}`);
          }

          const data = await res.json();
          console.log("Response:", data);

          if (data.success) {
            tr.remove();
          } else {
            alert("Fehler beim Löschen!");
          }
        } catch (error) {
          console.error("AJAX-Fehler:", error);
          alert("Verbindung zum Server fehlgeschlagen!");
        }
      }
    });
  });
});

document.querySelectorAll(".edit-btn").forEach((btn) => {
  btn.addEventListener("click", async (e) => {
    const tr = e.target.closest("tr");
    const id = tr.dataset.id;

    try {
      const formData = new FormData();
      formData.append("action", "get");
      formData.append("id", id);

      const res = await fetch(`${BASE_URL}/ajax/ajax_events.php`, { method: "POST", body: formData });
      const data = await res.json();

      if (data && data.id) {
        document.getElementById("edit-id").value = data.id;
        document.getElementById("edit-title").value = data.title || "";
        document.getElementById("edit-description").value = data.description || "";
        document.getElementById("edit-date").value = data.event_date || "";

        
        document.getElementById("edit-reminder").value = data.reminder_time_input || "";


        const modal = new bootstrap.Modal(document.getElementById("editModal"));
        modal.show();
      }
    } catch (err) {
      console.error("Fehler beim Laden:", err);
    }
  });
});



document.getElementById("editForm").addEventListener("submit", async (e) => {
  e.preventDefault();
  const fd = new FormData(e.target);
  fd.append("action", "update");

  try {
    const res = await fetch(`${BASE_URL}/ajax/ajax_events.php`, { method: "POST", body: fd });
    const text = await res.text();

    if (!text.trim()) {
      console.error("Server hat leere Antwort geschickt!");
      alert("Serverfehler – leere Antwort erhalten.");
      return;
    }

    let data;
    try {
      data = JSON.parse(text);
    } catch (err) {
      console.error("Ungültige JSON-Antwort:", text);
      alert("Ungültige Server-Antwort erhalten!");
      return;
    }

    console.log("Server Response:", data);

    if (data.success) {
      location.reload();
    } else if (Array.isArray(data.errors) && data.errors.length > 0) {
      // exact error message from server
      alert(data.errors.join("\n"));
    } else {
      // if no message from server
      alert("Fehler beim Aktualisieren!");
    }

  } catch (error) {
    console.error("AJAX Fehler:", error);
    alert("Verbindung zum Server fehlgeschlagen!");
  }
});

