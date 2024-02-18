const FALLBACK_GEO_LOCATION = {
    latitude: 23.777176,
    longitude: 90.399452,
}; // of "Dhaka"

const getGeoLocation = () => {
    return {
        geoLocation: JSON.parse(localStorage.getItem("user-location")) || {
            ...FALLBACK_GEO_LOCATION,
        },

        storeLocation(position) {
            this.geoLocation.latitude = position.coords.latitude.toFixed(6);
            this.geoLocation.longitude = position.coords.longitude.toFixed(6);
            localStorage.setItem(
                "user-location",
                JSON.stringify(this.geoLocation)
            );
        },

        init() {
            const storedGeoLocationLs =
                JSON.parse(localStorage.getItem("user-location")) || {};

            if (
                navigator.geolocation &&
                !Object.keys(storedGeoLocationLs).length
            ) {
                navigator.geolocation.getCurrentPosition(
                    this.storeLocation.bind(this)
                );
            }
        },
    };
};

export default getGeoLocation;
