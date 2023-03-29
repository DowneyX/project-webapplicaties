import * as React from 'react'
import StationInformationComponent from "./StationInformationComponent";
import StationMeasurementsComponent from "./StationMeasurementsComponent";
import {Chip, Divider, Typography} from "@mui/material";

export default function (props) {
    return (
        <>
            <Typography variant={"h4"} align={"center"}>
                Station {props.station}
            </Typography>
            <Divider sx={{ marginY: "20px" }}><Chip label={"Latest measurement"}/></Divider>
            <StationInformationComponent measurements={props.measurements}/>
            <Divider sx={{ marginY: "20px" }}><Chip label={"Measurements"}/></Divider>
            <StationMeasurementsComponent measurements={props.measurements}/>
        </>
    );
}