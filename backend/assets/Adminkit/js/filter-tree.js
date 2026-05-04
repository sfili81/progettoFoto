/* eslint-disable prettier/prettier */
jQuery(function ($) {
  var $detail = $(".kv-detail-container").first();
  if (!$detail.length) return;

  var $modalEl = document.getElementById("kv-node-modal");
  if (!$modalEl) return;

  var modal = new bootstrap.Modal($modalEl);

  // Aspetta che Kartik carichi il form nel pannello nascosto, poi apre il modal
  function waitAndOpenModal(title) {
    var attempts = 0;
    var interval = setInterval(function () {
      attempts++;
      if ($detail.find("form").length && !$detail.find(".kv-node-message").length) {
        clearInterval(interval);
        $("#kv-modal-title").text(title || "Dettaglio nodo");
        $("#kv-node-modal-body").html($detail.html());
        modal.show();
      }
      if (attempts > 20) clearInterval(interval); // timeout 2s
    }, 100);
  }

  // Modifica → click su kv-node-detail per triggerare Kartik
  $(document).on("click", ".kv-btn-edit", function (e) {
    e.stopPropagation();
    var $li = $(this).closest("li");
    var nodeName = $li.find("> .kv-tree-list .kv-node-label").text().trim();
    $li.find("> .kv-tree-list .kv-node-detail").trigger("click");
    waitAndOpenModal(nodeName || "Modifica nodo");
  });

  // + figlio nella toolbar
  $(document).on("click", ".kv-toolbar-container .kv-create", function () {
    waitAndOpenModal("Nuovo nodo figlio");
  });

  // + radice nella toolbar
  $(document).on("click", ".kv-toolbar-container .kv-create-root", function () {
    waitAndOpenModal("Nuova radice");
  });

  // Elimina → seleziona nodo poi triggera kv-remove
  $(document).on("click", ".kv-btn-delete", function (e) {
    e.stopPropagation();
    $(this).closest("li").find("> .kv-tree-list .kv-node-detail").trigger("click");
    setTimeout(function () {
      $(".kv-toolbar-container .kv-remove").trigger("click");
    }, 200);
  });

  // Chiudi modal dopo salvataggio
  $(document).on("submit", "#kv-node-modal-body form", function () {
    modal.hide();
  });
});
