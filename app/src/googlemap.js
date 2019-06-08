import { withScriptjs, withGoogleMap, GoogleMap Marker } from "react-google-maps"

const MyMapComponent = (props) =>
    <GoogleMap
        defaultZoom={8}
        defaultCenter={{ lat: -34.397, lng: 150.644 }}
    >
        {props.isMarkerShown && <Marker position={{ lat: -34.397, lng: 150.644 }} />}
    </GoogleMap>

    <MyMapComponent isMarkerShown />// Map with a Marker
<MyMapComponent isMarkerShown={false} />// Just only Map
googleMapURL="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=geometry,drawing,places"
loadingElement={<div style={{ height: `100%` }} />}
containerElement={<div style={{ height: `400px` }} />}
mapElement={<div style={{ height: `100%` }} />}
/>