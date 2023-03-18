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
    faCompass
} from '@fortawesome/free-solid-svg-icons'
export default function (props) {
    const measurement = props.measurements[0];

    return (
        <>
            <Grid container spacing={0}>
                <Grid item xs={6}>
                    <Grid container spacing={0}>
                        <Grid item xs={6} sx={{ textAlign: "center" }}>
                            <Typography variant={"h6"}>
                                Measurement <FontAwesomeIcon icon={faHashtag} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.id}
                            </Typography>
                        </Grid>
                        <Grid item xs={6} sx={{ textAlign: "center" }}>
                            <Typography variant={"h6"}>
                                Station <FontAwesomeIcon icon={faSatelliteDish} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.station}
                            </Typography>
                        </Grid>
                        <Grid item xs={6} sx={{ textAlign: "center" }}>
                            <Typography variant={"h6"}>
                                Timestamp <FontAwesomeIcon icon={faClock} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.timestamp}
                            </Typography>
                        </Grid>
                        <Grid item xs={6} sx={{ textAlign: "center" }}>
                            <Typography variant={"h6"}>
                                Temperature <FontAwesomeIcon icon={faTemperatureHigh} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.temperature}
                            </Typography>
                        </Grid>
                    </Grid>
                </Grid>
                <Grid item xs={6}>
                    <Grid container spacing={0}>
                        <Grid item xs={2.4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Dew Point <FontAwesomeIcon icon={faDroplet} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.dew_point}
                            </Typography>
                        </Grid>
                        <Grid item xs={2.4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Air Pressure <FontAwesomeIcon icon={faSatelliteDish} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.station_air_pressure}
                            </Typography>
                        </Grid>
                        <Grid item xs={2.4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Air Pressure <FontAwesomeIcon icon={faWater} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.sea_level_air_pressure}
                            </Typography>
                        </Grid>
                        <Grid item xs={2.4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Wind Speed <FontAwesomeIcon icon={faWind} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.wind_speed}
                            </Typography>
                        </Grid>
                        <Grid item xs={2.4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Precipitation <FontAwesomeIcon icon={faCloudShowersHeavy} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.precipitation}
                            </Typography>
                        </Grid>
                        <Grid item xs={2.4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Snow Depth <FontAwesomeIcon icon={faSnowflake} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.snow_depth}
                            </Typography>
                        </Grid>
                        <Grid item xs={2.4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                FRSHTT <FontAwesomeIcon icon={faTornado} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.FRSHTT}
                            </Typography>
                        </Grid>
                        <Grid item xs={2.4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Cloud Percent <FontAwesomeIcon icon={faCloudSun} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.cloud_percentage}%
                            </Typography>
                        </Grid>
                        <Grid item xs={2.4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Wind Direction <FontAwesomeIcon icon={faCompass} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.wind_direction}
                            </Typography>
                        </Grid>
                        <Grid item xs={2.4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Visibility <FontAwesomeIcon icon={faEyeLowVision} />
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.visibility}
                            </Typography>
                        </Grid>
                    </Grid>
                </Grid>
            </Grid>
        </>
    );
}