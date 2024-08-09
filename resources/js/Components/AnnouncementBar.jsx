import React, { useState, useEffect } from 'react';

function AnnouncementBar({ offers }) {
    const [show, setShow] = useState(true);
    const [currentOfferIndex, setCurrentOfferIndex] = useState(0);

    useEffect(() => {
        if (!show) {
            return;
        }

        const interval = setInterval(() => {
            setCurrentOfferIndex((prevIndex) => (prevIndex + 1) % offers.length);
        }, 5000);

        return () => clearInterval(interval);
    }, [show, offers.length]);

    if (!show) {
        return null;
    }

    return (
        <div className='bg-blue-500 text-white text-center py-2 px-4 relative'>
            <a href={offers[currentOfferIndex]?.link}>
            <p className='text-sm md:text-base hover:underline'>
                {offers[currentOfferIndex]?.text}
            </p>
            </a>
            <button
                className='absolute right-4 top-1/2 transform -translate-y-1/2 text-2xl text-white hover:text-red-500'
                onClick={() => setShow(false)}
            >
                &times;
            </button>
        </div>
    );
}

export default AnnouncementBar;
