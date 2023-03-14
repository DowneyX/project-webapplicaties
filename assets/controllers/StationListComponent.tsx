import * as React from 'react'
import {DataGrid, GridRowsProp, GridColDef} from "@mui/x-data-grid";

export default function (props) {

    const rows: GridRowsProp = props.stations

    const columns: GridColDef[] = [
        {field: 'id', headerName: 'Station ID', width: 150},
        {field: 'longitude', headerName: 'Latitude', flex: 1},
        {field: 'latitude', headerName: 'Longitude', flex: 1},
        {field: 'country_code', headerName: 'Country Code', flex: 1},
        {field: 'country', headerName: 'Country', flex: 1},
        {field: 'city', headerName: 'City', flex: 1},
    ];

    return (
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
    );
}