document.addEventListener("DOMContentLoaded", function () {
  $.getJSON("api/numberOfUsersPerCountry.php", {}, function (data) {
    var dataC = eval(data);
    var clients = [];
    $.each(dataC.countries, function () {
      clients[this.id] = this.value;
    });

    $("#map").vectorMap({
      map: "world_merc",
      backgroundColor: "transparent",
      series: {
        regions: [
          {
            values: clients,
            scale: ["#e6e6e6", "#007bff"],
            normalizeFunction: "polynomial",
          },
        ],
      },
      regionStyle: {
        hover: {
          fill: "#0056b3",
          cursor: "pointer",
        },
      },

      onRegionTipShow: function (e, el, code) {
        if (typeof clients[code] != "undefined") {
          el.html(el.html() + " (" + clients[code] + " Clients)");
        }
      },
    });
  });
});
