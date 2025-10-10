
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

      const res = await fetch(`${BASE_URL}/ajax/ajax_events.php`, {
        method: "POST",
        body: formData,
      });

      const data = await res.json();

      if (data && data.id) {
        document.getElementById("edit-id").value = data.id;
        document.getElementById("edit-title").value = data.title;
        document.getElementById("edit-description").value = data.description;
        document.getElementById("edit-date").value = data.event_date;
        document.getElementById("edit-reminder").value = data.reminder_time ?? "";

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
  const formData = new FormData(e.target);
  formData.append("action", "update");

  const res = await fetch(`${BASE_URL}/ajax/ajax_events.php`, {
    method: "POST",
    body: formData,
  });

  const data = await res.json();
  if (data.success) {
    location.reload();
  } else {
    alert("Fehler beim Aktualisieren!");
  }
});
