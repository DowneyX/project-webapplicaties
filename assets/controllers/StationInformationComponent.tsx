import * as React from 'react'
import {Grid, Typography} from '@mui/material'
import {
    AcUnitSharp,
    AirSharp, CloudSharp,
    DeviceThermostatSharp, FilterDramaSharp,
    Grid3x3Sharp,
    OpacitySharp,
    QueryBuilderSharp,
    SatelliteAltSharp, ThunderstormSharp, VisibilitySharp, WavesSharp, WindPowerSharp
} from "@mui/icons-material";
export default function (props) {
    const measurement = props.measurements[0];

    return (
        <>
            <Grid container spacing={0}>
                <Grid item xs={6}>
                    <Grid container spacing={0}>
                        <Grid item xs={6} sx={{ textAlign: "center" }}>
                            <Typography variant={"h6"}>
                                ID <Grid3x3Sharp sx={{ verticalAlign:  "middle" }}/>
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.id}
                            </Typography>
                        </Grid>
                        <Grid item xs={6} sx={{ textAlign: "center" }}>
                            <Typography variant={"h6"}>
                                Station <SatelliteAltSharp sx={{ verticalAlign:  "middle" }}/>
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.station}
                            </Typography>
                        </Grid>
                        <Grid item xs={6} sx={{ textAlign: "center" }}>
                            <Typography variant={"h6"}>
                                Timestamp <QueryBuilderSharp sx={{ verticalAlign:  "middle" }}/>
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.timestamp}
                            </Typography>
                        </Grid>
                        <Grid item xs={6} sx={{ textAlign: "center" }}>
                            <Typography variant={"h6"}>
                                Temperature <DeviceThermostatSharp sx={{ verticalAlign:  "middle" }}/>
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.temperature}
                            </Typography>
                        </Grid>
                    </Grid>
                </Grid>
                <Grid item xs={6}>
                    <Grid container spacing={0}>
                        <Grid item xs={4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Dew Point <OpacitySharp sx={{ verticalAlign:  "middle" }}/>
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.dew_point}
                            </Typography>
                        </Grid>
                        <Grid item xs={4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Station Air Pressure <AirSharp sx={{ verticalAlign:  "middle" }}/>
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.station_air_pressure}
                            </Typography>
                        </Grid>
                        <Grid item xs={4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Sea Level Air Pressure <WavesSharp sx={{ verticalAlign:  "middle" }}/>
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.sea_level_air_pressure}
                            </Typography>
                        </Grid>
                        <Grid item xs={4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Wind Speed <WindPowerSharp sx={{ verticalAlign:  "middle" }}/>
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.wind_speed}
                            </Typography>
                        </Grid>
                        <Grid item xs={4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Precipitation <ThunderstormSharp sx={{ verticalAlign:  "middle" }}/>
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.precipitation}
                            </Typography>
                        </Grid>
                        <Grid item xs={4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Snow Depth <AcUnitSharp sx={{ verticalAlign:  "middle" }}/>
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.snow_depth}
                            </Typography>
                        </Grid>
                        <Grid item xs={4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                FRSHTT <FilterDramaSharp sx={{ verticalAlign:  "middle" }}/>
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.FRSHTT}
                            </Typography>
                        </Grid>
                        <Grid item xs={4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Cloud Percentage <CloudSharp sx={{ verticalAlign:  "middle" }}/>
                            </Typography>
                            <Typography variant={"subtitle1"}>
                                {measurement.cloud_percentage}%
                            </Typography>
                        </Grid>
                        <Grid item xs={4} sx={{ textAlign: "center" }}>
                            <Typography variant={"subtitle1"}>
                                Visibility <VisibilitySharp sx={{ verticalAlign:  "middle" }}/>
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