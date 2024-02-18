import "./bootstrap";
import "flowbite";
import "mapbox-gl/dist/mapbox-gl.css";
import imageViewer from "./imageViewer";
import preserveScroll from "./preserveScroll";
import customModalHandler from "./customModalHandler";
import getGeoLocation from "./getGeoLocation";
import getShopGeoLocation from "./getShopGeoLocation";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.data("imageViewer", imageViewer);
Alpine.data("preserveScroll", preserveScroll);
Alpine.data("customModalHandler", customModalHandler);
Alpine.data("getGeoLocation", getGeoLocation);
Alpine.data("getShopGeoLocation", getShopGeoLocation);

// import mapboxgl from "mapbox-gl"; // or "const mapboxgl = require('mapbox-gl');"

// mapboxgl.accessToken = import.meta.env.VITE_MAPBOX_ACCESS_TOKEN;
// const map = new mapboxgl.Map({
//     container: "map", // container ID
//     style: "mapbox://styles/mapbox/streets-v12", // style URL
//     center: [-74.5, 40], // starting position [lng, lat]
//     zoom: 9, // starting zoom
// });

Alpine.start();
