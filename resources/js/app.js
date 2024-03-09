import "./bootstrap";
import "flowbite";
import "mapbox-gl/dist/mapbox-gl.css";
import imageViewer from "./imageViewer";
import preserveScroll from "./preserveScroll";
import customModalHandler from "./customModalHandler";
import getGeoLocation from "./getGeoLocation";
import geoLocationPicker from "./geoLocationPicker";

import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";

window.Alpine = Alpine;

Alpine.data("imageViewer", imageViewer);
Alpine.data("preserveScroll", preserveScroll);
Alpine.data("customModalHandler", customModalHandler);
Alpine.data("getGeoLocation", getGeoLocation);
Alpine.data("geoLocationPicker", geoLocationPicker);

Livewire.start();
