import * as React from 'react'
import {DataGrid, GridRowsProp, GridColDef} from "@mui/x-data-grid";

export default function (props) {
    console.log(props.stations.map(x => {"id": x}))

    const rows: GridRowsProp = [

    ];

    const columns: GridColDef[] = [
        {field: 'col1', headerName: 'Station ID', width: 150}
    ];

    return (
        <div>
            {/*<DataGrid columns={columns} rows={rows} />*/}
        </div>
    );
}