import NavBar from '@/Components/NavBar'
import React from 'react'
import MinusCircle from '@/Components/HeroIcons/MinusCircle'
import PlusCircle from '@/Components/HeroIcons/PlusCircle'
import Trash2 from '@/Components/HeroIcons/Trash2'
import { router } from '@inertiajs/react'

function Cart({ cartItems ,auth}) {


    function updateCartItem(id,operator) {
        router.patch(route('cart.update', { 'id': id, 'operator': operator }))
    }

    function deleteCartItem(id) {
        router.delete(route('cart.destroy', { 'id': id}))

    }

    return (
        <div>
            <NavBar auth={auth}/>
            <div className="bg-white shadow-lg rounded-lg mx-4 my-8 sm:mx-8 md:mx-16 lg:mx-32">
                <div className="px-6 py-8">
                    <h2 className="text-2xl font-bold mb-6">Your Cart</h2>
                    {cartItems.map((item) => (
                        <div
                            key={item.id}
                            className="flex items-center justify-between mb-6 border-b pb-6"
                        >
                            <div className="flex items-center">
                                <img
                                    src={item.image}
                                    alt={item.name}
                                    className="w-20 h-20 mr-4 rounded"
                                />
                                <div>
                                    <h3 className="text-lg font-medium">{item.name}</h3>
                                    <div className="flex items-center mt-2">
                                        <button onClick={() => { updateCartItem(item.id,"minus") }} className="text-gray-500 hover:text-gray-700 mr-2">
                                            <MinusCircle size={20} />
                                        </button>
                                        <span className="text-gray-700 font-medium mr-2">
                                            {item.quantity}
                                        </span>
                                        <button onClick={() => { updateCartItem(item.id,"add") }} className="text-gray-500 hover:text-gray-700 mr-2">
                                            <PlusCircle size={20} />
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div className="text-right">
                                <p className="text-lg font-medium">${item.price * item.quantity}</p>
                                <p className="text-sm text-gray-500">base price: ${item.price.toFixed(2)}</p>
                                <button onClick={() => { deleteCartItem(item.id) }} className="text-gray-500 hover:text-gray-700 mt-2">
                                    <Trash2 size={20} />
                                </button>
                            </div>
                        </div>
                    ))}
                    <div className="flex justify-end">
                        <button className="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Cart
