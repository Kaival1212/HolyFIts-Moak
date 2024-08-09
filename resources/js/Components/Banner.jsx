import { Link } from '@inertiajs/react';
import React, { useRef, useState, useEffect } from 'react';

function Banner({ bannerData }) {
    const scrollContainerRef = useRef(null);
    const [currentIndex, setCurrentIndex] = useState(0);

    const updateIndex = () => {
        if (scrollContainerRef.current) {
            const bannerWidth = scrollContainerRef.current.offsetWidth;
            const currentScrollPosition = scrollContainerRef.current.scrollLeft;
            const newIndex = Math.round(currentScrollPosition / bannerWidth);
            setCurrentIndex(newIndex);
        }
    };

    useEffect(() => {
        const scrollInterval = setInterval(() => {
            if (scrollContainerRef.current) {
                const bannerWidth = scrollContainerRef.current.offsetWidth;
                const currentScrollPosition = scrollContainerRef.current.scrollLeft;
                const maxScrollPosition = scrollContainerRef.current.scrollWidth - bannerWidth;
                const newScrollPosition = currentScrollPosition + bannerWidth;

                scrollContainerRef.current.scrollTo({
                    left: newScrollPosition > maxScrollPosition ? 0 : newScrollPosition,
                    behavior: 'smooth'
                });

                updateIndex();
            }
        }, 5000);

        return () => clearInterval(scrollInterval);
    }, []);

    useEffect(() => {
        const handleScroll = () => {
            updateIndex();
        };

        const scrollContainer = scrollContainerRef.current;
        if (scrollContainer) {
            scrollContainer.addEventListener('scroll', handleScroll);
        }

        return () => {
            if (scrollContainer) {
                scrollContainer.removeEventListener('scroll', handleScroll);
            }
        };
    }, []);

    return (
        <div className="relative w-full">
            <div
                ref={scrollContainerRef}
                className="flex overflow-x-hidden snap-x snap-mandatory"
            >
                {bannerData.map((banner, index) => (
                    <a
                        target="_blank"
                        rel="noopener noreferrer"
                        href={banner.link}
                        key={index}
                        className="w-full flex-shrink-0 h-[50vh] md:h-[60vh] relative snap-start"
                    >
                        <img
                            src={banner.image}
                            className="w-full h-full object-cover absolute"
                            alt={banner.title}
                        />
                        <div className="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                            <div className="text-center text-white">
                                <h2 className="text-3xl md:text-4xl font-bold mb-2">{banner.title}</h2>
                                <p className="text-lg md:text-xl">{banner.subtitle}</p>
                            </div>
                        </div>
                    </a>
                ))}
            </div>
            <div className="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3">
                {bannerData.map((_, index) => (
                    <button
                        key={index}
                        className={`w-3 h-3 rounded-full transition-all duration-300 ${
                            index === currentIndex ? 'bg-white scale-125' : 'bg-gray-400 hover:bg-gray-300'
                        }`}
                        onClick={() => {
                            if (scrollContainerRef.current) {
                                const bannerWidth = scrollContainerRef.current.offsetWidth;
                                scrollContainerRef.current.scrollTo({
                                    left: index * bannerWidth,
                                    behavior: 'smooth'
                                });
                                setCurrentIndex(index);
                            }
                        }}
                        aria-label={`Go to slide ${index + 1}`}
                    ></button>
                ))}
            </div>
        </div>
    );
}

export default Banner;
