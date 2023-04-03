import * as React from 'react'
import {AppBar, Box, Button, IconButton, Toolbar, Typography} from "@mui/material";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import { faHouse } from '@fortawesome/free-solid-svg-icons'
import { motion } from "framer-motion";

export default function(props) {
    return (
        <Box sx={{ flexGrow: 1, marginBottom: "30px" }}>
            <AppBar position="static">
                <Toolbar>
                    <IconButton
                        size="small"
                        edge="start"
                        color="inherit"
                        aria-label="menu"
                        sx={{ mr: 2 }}
                        href={"/"}
                    >
                        <FontAwesomeIcon icon={faHouse} />
                    </IconButton>
                    <Button color="inherit" href={"/monitor"}>Monitor</Button>
                    <Button color="inherit" href={"/login"}>Login</Button>
                    <Button color="inherit" href={"/logout"}>Logout</Button>
                </Toolbar>
            </AppBar>
        </Box>
    );
}