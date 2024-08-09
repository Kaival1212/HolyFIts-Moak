import { Link } from '@inertiajs/react';
import React from 'react';

function ProductsCardList({ collection, products }) {
    return (
        <div className='mt-12 px-4 md:px-8'>
            <Link href={route('collection.show',[collection.slug])} className='text-4xl font-bold capitalize text-black mb-2 libre-baskerville-bold hover:underline'>
                {collection.name}
            </Link>

            <div className='flex overflow-x-auto gap-8 py-4 no-scrollbar'>
                {products.map((product) => (
                    <div key={product.id} className='flex-shrink-0 w-72 bg-white border rounded-lg border-gray-200 cursor-pointer libre-baskerville-regular shadow-md hover:shadow-md overflow-hidden transition-all duration-300'>
                        <div className='h-64 overflow-hidden'>
                            <img src={product.image} className='w-full h-full object-cover transition-transform duration-300 hover:scale-105' alt={product.name} />
                        </div>
                        <div className='p-6'>
                            <h3 className='text-xl font-semibold text-black mb-3 truncate'>{product.name}</h3>
                            <p className='text-sm text-gray-600 mb-4 line-clamp-2'>{product.description}</p>
                            <div className='flex justify-between items-center'>
                                <span className='text-lg font-bold text-black'>${product.cheapestVariantPrice || 100}</span>
                                <Link href={route('product.show',[collection.slug,product.id])} className='px-4 py-2 bg-black text-white text-sm hover:bg-gray-800 transition-colors duration-300'>
                                    View Details
                                </Link>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}

export default ProductsCardList;
