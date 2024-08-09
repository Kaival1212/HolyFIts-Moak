import React from 'react';
import CartIcon from '@/Components/HeroIcons/CartIcon';
import HeartIcon from '@/Components/HeroIcons/HeartIcon';
import Profile from '@/Components/Profile';
import { Link } from '@inertiajs/react';
import MagnifyingGlassIcon from './HeroIcons/MagnifyingGlassIcon';
import Dropdown from './Dropdown';

function NavBar({ auth }) {
    const appUrl = import.meta.env.VITE_APP_URL;

    console.log(auth)
    return (
        <>
            <div className='shadow-xl'>
                <nav className='flex flex-col md:flex-row p-3 md:justify-around items-center bg-white'>
                    <div className='flex justify-between items-center w-full md:w-auto'>
                        <Link href={route('home')}>
                            <img src={`${appUrl}/logo.png`} alt="Logo" className='h-14 w-auto' />
                        </Link>
                        <div className='flex gap-6 md:hidden'>
                            <div className='hover:text-gray-700 hover:scale-105'><HeartIcon /></div>
                            <Link href={route('cart.index')} className='hover:text-gray-700 hover:scale-105'><CartIcon /></Link>
                            <div className='hover:text-gray-700 hover:scale-105'><Profile /></div>
                        </div>
                    </div>

                    <ul className='flex gap-6 mt-4 md:mt-0 justify-center'>
                        <Link href={route('home')} className='hover:underline hover:text-gray-900'>Men</Link>
                        <Link href={route('home')} className='hover:underline hover:text-gray-900'>Women</Link>
                        <Link href={route('home')} className='hover:underline hover:text-gray-900'>Kids</Link>
                        <Link href={route('home')} className='hover:underline hover:text-gray-900'>Shop</Link>
                        <Link href={route('home')} className='hover:underline hover:text-gray-900'>Contact us</Link>
                    </ul>

                    <form className='flex relative mt-4 md:mt-0 w-full md:w-auto'>
                        <input
                            type='text'
                            placeholder='Search here'
                            className='bg-[#F0F0F0] border-none rounded-md w-full md:w-80 peer focus:outline-none focus:ring-2 focus:ring-blue-500'
                        />
                        <div className='absolute right-3 top-1/2 transform -translate-y-1/2 peer-focus:text-blue-600'>
                            <MagnifyingGlassIcon className='h-10 w-5' />
                        </div>
                    </form>

                    <div className='hidden md:flex gap-6'>
                        {/* <div className='hover:text-gray-700 hover:scale-105'><HeartIcon /></div> */}
                        <Link href={route('cart.index')} className='hover:text-gray-700 hover:scale-105'><CartIcon /></Link>

                        {auth.user ?
                            <Dropdown>
                                <Dropdown.Trigger>
                                    <span className="inline-flex rounded-md">
                                    <button
                                                type="button"
                                                className="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {auth.user.name}

                                                <svg
                                                    className="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fillRule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clipRule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                    </span>
                                </Dropdown.Trigger>

                                <Dropdown.Content>
                                    <Dropdown.Link href={route('profile.edit')}>Profile</Dropdown.Link>
                                    <Dropdown.Link >Orders</Dropdown.Link>
                                    <Dropdown.Link href={route('logout')} method="post" as="button">
                                        Log Out
                                    </Dropdown.Link>
                                </Dropdown.Content>
                            </Dropdown>
                            :
                            <Link href={route('login')} className=''>Sign In</Link>
                        }
                    </div>
                </nav>
            </div>
        </>
    );
}

export default NavBar;
