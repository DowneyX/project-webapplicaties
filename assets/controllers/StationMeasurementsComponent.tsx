import * as React from 'react'
import {Grid, Typography} from '@mui/material'
import {DataGrid, GridColDef, GridRowsProp} from "@mui/x-data-grid";
export default function (props) {
    const rows: GridRowsProp = props.measurements;

    const columns: GridColDef[] = [
        {field: 'id', headerName: 'ID', width: 150},
        {field: 'station', headerName: 'Station ID', flex: 1},
        {field: 'timestamp', headerName: 'Time', flex: 1},
        {field: 'temperature', headerName: 'Temperature', flex: 1},
        {field: 'dew_point', headerName: 'Dew Point', flex: 1},
        {field: 'station_air_pressure', headerName: 'Station Air Pressure', flex: 1},
        {field: 'sea_level_air_pressure', headerName: 'Sea Level Air Pressure', flex: 1},
        {field: 'wind_speed', headerName: 'Wind Speed', flex: 1},
        {field: 'precipitation', headerName: 'Precipitation', flex: 1},
        {field: 'snow_depth', headerName: 'Snow Depth', flex: 1},
        {field: 'FRSHTT', headerName: 'FRSHTT', flex: 1},
        {field: 'cloud_percentage', headerName: 'Cloud Percentage', flex: 1},
        {field: 'wind_direction', headerName: 'Wind Direction', flex: 1},
        {field: 'visibility', headerName: 'Visibility', flex: 1},
    ];

    return (
        <>
            <div style={{width: "100%", height: "500px"}}>
                <DataGrid
                    columns={columns}
                    rows={rows}
                    initialState={{
                        pagination: { paginationModel: { pageSize: 10 } },
                    }}
                    autoHeight={true}
                />
            </div>
        </>
    );
}