jQuery(function ($) {

  // Init Color Picker
  $(".color-field").wpColorPicker();

  /* 
  ========= ON OFF ICONS ==========
  */
  function on_off_icon(status, id, table) {
    var myStatus = status;

    $.ajax({
      type: "POST",
      url: ajaxOnOffGen.url,
      data: {
        action: "gen_change_status_icons",
        nonce: ajaxOnOffGen.security,
        iconStatus: myStatus,
        id: id,
        table: table,
      },
      success: function (res) {
        console.log(res);
      },
    });
  }

  if ($("#gen-btn-content").hasClass("stat-on")) {
    $(".gen-admin-content").show();
  }

  $(".btn-on-off").on("click", function (e) {
    e.preventDefault();

    var id = $(this).attr("data-id");
    var table = $(this).attr("data-table");

    if ($(this).hasClass("stat-off")) {
      $(this).removeClass("stat-off");
      $(this).addClass("stat-on");
      on_off_icon("on", id, table);

      if (table == "gen_icons_general") {
        $(".gen-admin-content").fadeIn();
      }
    } else {
      $(this).removeClass("stat-on");
      $(this).addClass("stat-off");
      on_off_icon("off", id, table);
      if (table == "gen_icons_general") {
        $(".gen-admin-content").fadeOut();
      }
    }
  });


  /**
   * DELETE ICON
   */

  // AJAX FUNCTION DELETE
  function gen_delete_icon(id) {
    $.ajax({
      type: "POST",
      url: ajaxRequest.url,
      data: {
        action: "requestDelete",
        nonce: ajaxRequest.security,
        id: id,
      },
      success: function () {
        alert("Datos borrados");
        location.reload();
      },
    });
  }

  // PROCESS TO DELETE
  $(document).on("click", function (e) {
    const element = e.target;
    if (element.classList.contains("btnDelete")) {
      const dataId = element.dataset.id;
      gen_delete_icon(dataId)
    }
  });

  /**
   * UPDATE ICONS
   */
  $(".btnUpdate").on("click", function () {
    var dataRes = jQuery.parseJSON($(this).attr("data-res"));

    const objectData = dataRes.data
    const jsonObjectData = JSON.parse(objectData)

    $("#gen-modal-update").on("shown.bs.modal", function (event) {
      // idIcon
      $("#gen-modal-update #idIcon").val(`${dataRes.IconId}`);
      $("#gen-modal-update #title").val(`${dataRes.title}`);
      $("#gen-modal-update #link").val(`${jsonObjectData.link}`);
      $(
        "#gen-modal-update #alignLabelText option[value=" +
          jsonObjectData.alignLabelText +
          "]"
      ).attr("selected", true);

      // Color bg
      $("#gen-modal-update #bgColor").val(`${jsonObjectData.bgColor}`);
      $("#gen-modal-update #bgColor")
        .parent()
        .parent()
        .parent()
        .find(".wp-color-result")
        .css("background", `${jsonObjectData.bgColor}`);

      // Color hover bg
      $("#gen-modal-update #bgColorHover").val(`${jsonObjectData.bgColor_hover}`);
      $("#gen-modal-update #bgColorHover")
        .parent()
        .parent()
        .parent()
        .find(".wp-color-result")
        .css("background", `${jsonObjectData.bgColor_hover}`);
      $(
        "#gen-modal-update #styleIcon option[value=" + jsonObjectData.style + "]"
      ).attr("selected", true);
      $(
        "#gen-modal-update #typeIcon option[value=" + jsonObjectData.typeIcon + "]"
      ).attr("selected", true);
      $(
        "#gen-modal-update #typeIcon option[value=" + jsonObjectData.typeIcon + "]"
      ).attr("selected", true);
      $("#gen-modal-update #faIcon").val(`${jsonObjectData.faIcon}`);

      // Color icon
      $("#gen-modal-update #iconColor").val(`${jsonObjectData.colorIcon}`);
      $("#gen-modal-update #iconColor")
        .parent()
        .parent()
        .parent()
        .find(".wp-color-result")
        .css("background", `${jsonObjectData.colorIcon}`);

      // Color icon hover
      $("#gen-modal-update #iconColorHover").val(`${jsonObjectData.colorIcon_hover}`);
      $("#gen-modal-update #iconColorHover")
        .parent()
        .parent()
        .parent()
        .find(".wp-color-result")
        .css("background", `${jsonObjectData.colorIcon_hover}`);
    });
  });

  $("#btnEditGeneral").on("click", function (e) {
    e.preventDefault();
    $("#textLabelClose").attr("disabled", false);
    $("#alignLabelTextGen").attr("disabled", false);
    $("#btnSaveGeneral").attr("disabled", false);

    var initValLabel = $("#textLabelClose").val();
    var initValAlign = $("#alignLabelTextGen").val();

    $("#gen-form-upd-general").on("change", function () {
      if (
        initValLabel != $("#textLabelClose").val() ||
        initValAlign != $("#alignLabelTextGen").val()
      ) {
        $("#btnCancelGeneral").attr("disabled", false);
      } else {
        $("#btnCancelGeneral").attr("disabled", true);
      }
    });

    $("#btnCancelGeneral").on("click", function (e) {
      e.preventDefault();

      $("#textLabelClose").val(initValLabel);
      $("#alignLabelTextGen option").attr("selected", false);
      $("#alignLabelTextGen option[value=" + initValAlign + "]").attr(
        "selected",
        true
      );

      $("#textLabelClose").attr("disabled", true);
      $("#alignLabelTextGen").attr("disabled", true);
      $("#btnSaveGeneral").attr("disabled", true);
      $("#btnCancelGeneral").attr("disabled", true);
    });
  });

  function ajaxUpdOrderJs(items){
      $.ajax({
          type: "POST",
          url: ajaxUpdOrder.url,
          data: {
              action: "gen_upd_order",
              nonce: ajaxUpdOrder.security,
              items: items
          },
          success: function(res) {
              console.log(res)
          }
      });
  }
  
  $(".gen-list-reordering__cancel").hide();
  $(".gen-list-reordering").on("click", function (e) {
    e.preventDefault();

    $(".gen-list-reordering__cancel").show();

    if ($(this).attr("data-handle") == "false") {
      localStorage.removeItem("localStorage-genicons");
      $(".gen-icon-list").css("opacity", 0.5);
      $(this).find("span").text("Guardar");
      $(this).removeClass("btn-light");
      $(this).addClass("btn-primary");
      $(this).attr("data-handle", true);
      $(".gen-icon-dragg").addClass("active");
      new Sortable(document.getElementById("gen-icon-list"), {
        // options here
        group: "localStorage-genicons",
        store: {
          /**
           * Get the order of elements. Called once during initialization.
           * @param   {Sortable}  sortable
           * @returns {Array}
           */
          get: function (sortable) {
            var order = localStorage.getItem(sortable.options.group.name);
            return order ? order.split("|") : [];
          },

          /**
           * Save the order of elements. Called onEnd (when the item is dropped).
           * @param {Sortable}  sortable
           */
          set: function (sortable) {
            var order = sortable.toArray();
            localStorage.setItem(sortable.options.group.name, order.join("|"));
          },
        },
        sort: true,
        animation: 200,
        // handle: ".gen-icon-dragg",
        dataIdAttr: "data-id",
      });
    } else {
      var localItem = localStorage.getItem("localStorage-genicons");
      if (localItem) {
        $(".gen-icon-list").css("opacity", 1);
        $(this).find("span").text("Reordenar");
        $(this).removeClass("btn-primary");
        $(this).addClass("btn-light");
        $(".gen-icon-dragg").removeClass("active");
        $(this).attr("data-handle", false);
        var localArr = localItem.split("|");

        var updateList = [];
        $(localArr).each(function (index) {
          var oldId = parseInt(this);
          var currId = parseInt(index + 1);

          updateList.push({
            "oldId": oldId,
            "currId": currId,
          });
        });

        ajaxUpdOrderJs(updateList)

      } else {
        alert("No haz realizado cambios");
        return false;
      }
    }

    // Button Cancel Order
    $(".gen-list-reordering__cancel").on("click", function (e) {
      e.preventDefault();
      $(".gen-icon-list").css("opacity", 1);
      $(".gen-list-reordering").find("span").text("Reordenar");
      $(".gen-list-reordering").removeClass("btn-primary");
      $(".gen-list-reordering").addClass("btn-light");
      $(".gen-icon-dragg").removeClass("active");
      $(".gen-list-reordering").attr("data-handle", false);
      $(this).hide();
    });
  });
});
