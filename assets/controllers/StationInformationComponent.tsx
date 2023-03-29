import * as React from 'react'
import {Grid, Typography} from '@mui/material'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { solid } from '@fortawesome/fontawesome-svg-core/import.macro'
import {
    faTemperatureHigh,
    faSatelliteDish,
    faHashtag,
    faClock,
    faDroplet,
    faWind,
    faGauge,
    faWater,
    faCloudShowersHeavy,
    faSnowflake,
    faTornado,
    faCloudSun,
    faEyeLowVision,
    faCompass, IconDefinition
} from '@fortawesome/free-solid-svg-icons'
import {motion} from "framer-motion";
export default function (props) {
    const measurement = props.measurements[0];

    interface Data {
        icon: IconDefinition,
        name: string
    }

    interface DataInterface {
        [key: string]: Data
    }

    const primaryData: DataInterface = {
        "id": {
            "icon": faHashtag,
            "name": "ID"
        },
        "station": {
            "icon": faSatelliteDish,
            "name": "Station"
        },
        "timestamp": {
            "icon": faClock,
            "name": "Timestamp"
        },
        "temperature": {
            "icon": faTemperatureHigh,
            "name": "Temperature"
        }
    };

    const secondaryData: DataInterface = {
        "dew_point": {
            "icon": faDroplet,
            "name": "Dew Point"
        },
        "station_air_pressure": {
            "icon": faSatelliteDish,
            "name": "Air Pressure"
        },
        "sea_level_air_pressure": {
            "icon": faWater,
            "name": "Air Pressure"
        },
        "wind_speed": {
            "icon": faWind,
            "name": "Wind Speed"
        },
        "precipitation": {
            "icon": faCloudShowersHeavy,
            "name": "Precipitation"
        },
        "snow_depth": {
            "icon": faSnowflake,
            "name": "Snow Depth"
        },
        "FRSHTT": {
            "icon": faTornado,
            "name": "FRSHTT"
        },
        "cloud_percentage": {
            "icon": faCloudSun,
            "name": "Cloud Percent"
        },
        "wind_direction": {
            "icon": faCompass,
            "name": "Wind Direction"
        },
        "visibility": {
            "icon": faEyeLowVision,
            "name": "Visibility"
        }
    };

    return (
        <>
            <Grid container spacing={0}>
                <Grid item xs={6}>
                    <Grid container spacing={0}>
                        {Object.keys(primaryData).map(x => {
                            return (
                                <Grid
                                    item
                                    xs={6}
                                    sx={{ textAlign: "center" }}
                                    component={motion.div}
                                    whileHover={{ scale: 1.2 }}
                                >
                                    <Typography variant={"h6"}>
                                        {primaryData[x].name} <FontAwesomeIcon icon={primaryData[x].icon} />
                                    </Typography>
                                    <Typography variant={"subtitle1"}>
                                        {measurement[x]}
                                    </Typography>
                                </Grid>
                            )
                        })}
                    </Grid>
                </Grid>
                <Grid item xs={6}>
                    <Grid container spacing={0}>
                        {Object.keys(secondaryData).map(x => {
                            return (
                                <Grid
                                    item
                                    xs={2.4}
                                    sx={{ textAlign: "center" }}
                                    component={motion.div}
                                    whileHover={{ scale: 1.2 }}
                                >
                                    <Typography variant={"subtitle1"}>
                                        {secondaryData[x].name} <FontAwesomeIcon icon={secondaryData[x].icon} />
                                    </Typography>
                                    <Typography variant={"subtitle1"}>
                                        {measurement[x]}
                                    </Typography>
                                </Grid>
                            )
                        })}
                    </Grid>
                </Grid>
            </Grid>
        </>
    );
}