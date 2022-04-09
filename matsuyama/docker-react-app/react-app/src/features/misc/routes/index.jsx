/* eslint-disable react/jsx-indent */
/* eslint-disable indent */
import { Route, Routes } from 'react-router-dom';

import { Pricing } from './Pricing';

export function MiscRoutes() {
    return (
        <Routes>
            <Route path="pricing" element={<Pricing />} />
        </Routes>
    );
}
