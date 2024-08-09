import NavBar from '@/Components/NavBar'
import { Head, usePage, Link } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'

function Collection({ auth, productsList, collection }) {
    const { url } = usePage();
    const [sortPrice, setSortPrice] = useState(' ');
    const [searchValue, setSearchvalue] = useState('');
    const [showSugg, setShowSugg] = useState(false)
    const [filteredProducts, setFilteredProducts] = useState([]);


    useEffect(() => {
        const urlParams = new URLSearchParams(window.location.search);
        const sortParam = urlParams.get('sort-price');
        const searcParam = urlParams.get('search')
        if (sortParam) {
            setSortPrice(sortParam);
        }
        if (searcParam) {
            setSearchvalue(searcParam)
        }
    }, [url]);

    const handleSortChange = (event) => {
        setSortPrice(event.target.value);
    };

    function handelSearchChange(e) {
        setSearchvalue(e.target.value);
    }

    return (
        <div className="bg-gray-100 min-h-screen">
            <Head title={collection.name} />
            <NavBar auth={auth}/>
            <div className=" mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <Link href={route('collection.show', [collection.slug])}><h1 className="text-5xl md:text-6xl hover:underline font-extrabold text-gray-900 mb-12 libre-baskerville-bold">{collection.name}</h1></Link>
                <div className="mb-10 bg-white shadow-md rounded-lg p-6">
                    <form action={url} method="GET" className="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                        <div className='flex-grow relative'>
                            <input
                                type="text"
                                name="search"
                                placeholder="Search products..."
                                className="w-full h-12 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300"
                                onFocus={() => { setShowSugg(true) }}
                                onBlur={() => { setTimeout(() => setShowSugg(false), 200) }}
                                onChange={(e) => { handelSearchChange(e) }}
                                value={searchValue}
                                autocomplete="off"
                            />
                            {showSugg && searchValue != ' ' && (
                                <div className='w-full bg-white absolute top-full mt-1 z-50 rounded-lg shadow-lg border border-gray-200'>
                                    {productsList.filter(product => product.name.toLowerCase().includes(searchValue.toLowerCase())).map((product) => (
                                        <Link href={route('collection.show', { slug: collection.slug, search: product.name })} key={product.id} className='block px-4 py-2 hover:bg-gray-100 transition-colors duration-200'>
                                            {product.name}
                                        </Link>)
                                    )}
                                </div>
                            )}
                        </div>
                        <div className="flex items-center space-x-3">
                            <label htmlFor="sort-price" className="text-gray-700 whitespace-nowrap">Sort by Price:</label>
                            <select
                                name="sort-price"
                                id="sort-price"
                                value={sortPrice}
                                onChange={handleSortChange}
                                className="h-12  py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300"
                            >
                                <option value="asc">Low to High</option>
                                <option value="desc">High to Low</option>
                            </select>
                        </div>
                        <button
                            type="submit"
                            className="h-12 px-6 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-300 whitespace-nowrap"
                        >
                            Apply Filters
                        </button>
                    </form>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    {productsList.map((product) => (
                        <div key={product.id} className="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                            <div className="aspect-w-1 aspect-h-1 overflow-hidden">
                                <img
                                    src={product.image}
                                    className="w-full h-full object-cover transform transition-transform duration-300 hover:scale-105"
                                    alt={product.name}
                                />
                            </div>
                            <div className="p-6">
                                <h3 className="text-xl font-semibold text-gray-900 mb-3 truncate libre-baskerville-regular">{product.name}</h3>
                                <p className="text-sm text-gray-600 mb-4 line-clamp-2">{product.description}</p>
                                <div className="flex justify-between items-center">
                                    <span className="text-2xl font-bold text-gray-900 libre-baskerville-bold">${product.cheapestVariantPrice}</span>
                                    <Link href={route('product.show',[collection.slug,product.id])} className="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-300">
                                        View Details
                                    </Link>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    )
}

export default Collection
