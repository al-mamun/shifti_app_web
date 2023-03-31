import React from 'react';

function Error({error}) {
    return(
        <p className="text-danger mt-2 mb-2">{error}</p>
    )
}

export default Error