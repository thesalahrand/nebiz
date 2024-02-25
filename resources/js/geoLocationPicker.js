import mapboxgl from "mapbox-gl";
import MapboxGeocoder from "@mapbox/mapbox-gl-geocoder";
import "@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css";

mapboxgl.accessToken = import.meta.env.VITE_MAPBOX_ACCESS_TOKEN;

let map, marker;

const geoLocationPicker = (latitude, longitude) => {
    return {
        geoLocation: { latitude, longitude },

        init() {
            map = new mapboxgl.Map({
                container: "map",
                style: "mapbox://styles/mapbox/streets-v12",
                center: [this.geoLocation.longitude, this.geoLocation.latitude],
                zoom: 9,
            });

            marker = new mapboxgl.Marker({
                color: "#111827",
            })
                .setLngLat([
                    this.geoLocation.longitude,
                    this.geoLocation.latitude,
                ])
                .addTo(map);

            map.addControl(
                new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    mapboxgl: mapboxgl,
                })
            );
            map.addControl(new mapboxgl.NavigationControl());

            map.on("click", (e) => {
                this.geoLocation.latitude = e.lngLat.lat.toFixed(8);
                this.geoLocation.longitude = e.lngLat.lng.toFixed(8);

                marker.setLngLat([e.lngLat.lng, e.lngLat.lat]);
            });
        },

        update() {
            map.flyTo({
                center: [this.geoLocation.longitude, this.geoLocation.latitude],
            });
            marker.setLngLat([
                this.geoLocation.longitude,
                this.geoLocation.latitude,
            ]);
        },
    };
};

export default geoLocationPicker;
