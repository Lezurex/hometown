const iconStyle = new ol.style.Style({
  image: new ol.style.Icon({
    anchor: [0.5, 1],
    scale: 0.5,
    anchorXUnits: "fraction",
    anchorYUnits: "fraction",
    src: "assets/marker_icon.svg",
  }),
});

const element = document.getElementById("popup");

const popup = new ol.Overlay({
  element: element,
  positioning: "bottom-center",
  stopEvent: false,
});

fetch("/php/getMarkers.php").then((res) =>
  res.json().then((markers) => {
    const features = markers.map((marker) => {
      const feature = new ol.Feature({
        geometry: new ol.geom.Point(
          ol.proj.fromLonLat([marker.lon, marker.lat])
        ),
        ...marker,
      });
      feature.setStyle(iconStyle);
      return feature;
    });
    const vectorSource = new ol.source.Vector({
      features: features,
    });

    const vectorLayer = new ol.layer.Vector({
      source: vectorSource,
    });

    const map = new ol.Map({
      target: "map",
      layers: [
        new ol.layer.Tile({
          source: new ol.source.OSM(),
        }),
        vectorLayer,
      ],
      view: new ol.View({
        center: ol.proj.fromLonLat([8.43, 46.8]),
        zoom: 8.3,
      }),
    });

    map.addOverlay(popup);

    map.on("click", function (e) {
      const feature = map.forEachFeatureAtPixel(e.pixel, function (feature) {
        return feature;
      });
      if (feature) {
        popup.setPosition(e.coordinate);
        element.innerHTML = `<p><b>${feature.A.title}</b></p>
        <p>${feature.A.address}</p>
        <p>${feature.A.city.postalCode} ${feature.A.city.name}</p>
        <p>${feature.A.city.country.name}</p>`;
        element.style.display = "block";
      }
    });

    map.on("movestart", function () {
      element.style.display = "none";
    });
  })
);
