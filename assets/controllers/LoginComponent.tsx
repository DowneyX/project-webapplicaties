import * as React from 'react';
import TextField from '@mui/material/TextField';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';

export default function () {
    return (
        <Box sx={{
            '& .MuiTextField-root': { m: 1, width: '25ch' },
        }}>
            <div>
                <h1>Inloggen</h1>
            </div>
            <div>
                <TextField
                    id="email"
                    label="Emailadres"
                    type="email"
                />
            </div>
            <div>
                <TextField
                    id="outlined-password-input"
                    label="Wachtwoord"
                    type="password"
                />
            </div>
            <div>
                <Button variant="text">Wachtwoord vergeten?</Button>
            </div>
            <div>
                <Button variant="contained">Inloggen</Button>
            </div>
        </Box>
    );
}