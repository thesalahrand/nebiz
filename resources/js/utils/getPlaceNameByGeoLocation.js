const getPlaceNameByGeoLocation = (latitude, longitude) => {
    const API_URL = `https://api.mapbox.com/geocoding/v5/mapbox.places/${longitude},${latitude}.json?access_token=${
        import.meta.env.VITE_MAPBOX_ACCESS_TOKEN
    }`;
    const PLACE_NOT_FOUND_TEXT = "Exact place name could't be found";

    return new Promise((resolve, reject) => {
        fetch(API_URL)
            .then((res) => res.json())
            .then((res) => {
                if (res?.features?.[0]?.place_name)
                    resolve(res.features[0].place_name);
                else reject(PLACE_NOT_FOUND_TEXT);
            })
            .catch((err) => reject(PLACE_NOT_FOUND_TEXT));
    });
};

export default getPlaceNameByGeoLocation;
