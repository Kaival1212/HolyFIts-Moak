import React, { useState } from 'react';
import NavBar from "@/Components/NavBar.jsx";
import { Head, Link, router } from "@inertiajs/react";

function Product({ product, collection, varients, selectedVarient,auth }) {
    const [errorMessage, setErrorMessage] = useState('');
    const variantTypes = Object.keys(varients);
    const [quantity, setQuantity] = useState(1);

    const handleAddToCart = () => {
        if (!selectedVarient) {
            setErrorMessage('Please select a variant before adding to cart.');
            return;
        }

        setErrorMessage('');
        router.post(route('cart.store'), { "id": selectedVarient.id, "quantity": quantity });
    };

    const addQuantity = () => {
        setQuantity(quantity + 1)
    }

    const minusQuantity = () => {

        if (quantity > 1) {
            setQuantity(quantity - 1)
        }
    }

    return (
        <div className="min-h-screen bg-gray-100">
            <NavBar auth={auth}/>
            <Head title={product.name} />
            <div className="p-6 max-w-7xl mx-auto">
                <div className="flex flex-col md:flex-row items-start md:items-center justify-between bg-white p-6 rounded-lg shadow-md">
                    <div className="w-full md:w-1/3">
                        <img
                            className="w-full rounded-lg hover:scale-105 transition-transform duration-300"
                            src={selectedVarient ? selectedVarient.image : product.image}
                            alt={product.name}
                        />
                    </div>
                    <div className="flex flex-col md:w-1/2 mt-6 md:mt-0 md:ml-10">
                        <h1 className="text-3xl font-bold libre-baskerville-bold mb-4">{product.name}</h1>
                        <p className="libre-baskerville-regular text-gray-700 mb-6 overflow-auto p-4">{product.description}</p>

                        <div className="flex flex-wrap gap-2 text-sm mb-2">
                            {product.tags.map((tag) => (
                                <Link
                                    key={tag}
                                    className="bg-blue-200 text-blue-800 rounded-full px-3 py-1 border border-blue-300"
                                >
                                    #{tag}
                                </Link>
                            ))}
                        </div>

                        <div className="flex flex-col gap-4 mb-6">
                            {variantTypes.map((type) => (
                                <div key={type}>
                                    <div className="text-lg font-semibold text-gray-800 mb-2">
                                        {type.charAt(0).toUpperCase() + type.slice(1)}
                                    </div>
                                    <div className="flex flex-wrap gap-2">
                                        {varients[type].map((variant) => (
                                            <Link
                                                key={variant.id}
                                                href={route('product.show', {
                                                    collection: collection.slug,
                                                    product: product.id,
                                                    varientId: variant.id
                                                })}
                                                className={`border px-4 py-2 rounded-full ${selectedVarient && selectedVarient.id === variant.id ? 'bg-gray-300' : 'bg-gray-200'} hover:bg-gray-300 transition-colors duration-300`}
                                            >
                                                {variant.attributes}
                                            </Link>
                                        ))}
                                    </div>
                                </div>
                            ))}
                        </div>
                        <div className="mb-6">
                            <h2 className="text-xl font-semibold mb-2">
                                ${selectedVarient ? selectedVarient.price : product.CheapestVarient}
                            </h2>
                        </div>
                        <div className="mb-6 flex gap-1 items-center">
                            <button
                                onClick={minusQuantity}
                                className="bg-gray-200 text-gray-800 hover:bg-gray-300  px-4 py-2 rounded-l-md "
                            >
                                -
                            </button>
                            <input
                                type="number"
                                className="border-t border-b border-gray-300 text-center w-16 "
                                value={quantity}
                                readOnly
                            />
                            <button
                                onClick={addQuantity}
                                className="bg-gray-200 text-gray-800 hover:bg-gray-300 px-4 py-2 rounded-r-md "
                            >
                                +
                            </button>
                        </div>
                        {errorMessage && (
                            <div className="text-red-500 mb-4">
                                {errorMessage}
                            </div>
                        )}
                        <div className="flex gap-4">
                            <button
                                className="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-300">
                                Buy Now
                            </button>
                            <button
                                onClick={handleAddToCart}
                                className="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors duration-300">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Product;
