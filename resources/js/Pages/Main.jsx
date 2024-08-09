import AnnouncementBar from '@/Components/AnnouncementBar';
import Banner from '@/Components/Banner';
import CartIcon from '@/Components/HeroIcons/CartIcon';
import HeartIcon from '@/Components/HeroIcons/HeartIcon';
import NavBar from '@/Components/NavBar';
import ProductsCardList from '@/Components/ProductsCardList';
import Profile from '@/Components/Profile';
import { Link, Head } from '@inertiajs/react';

export default function Welcome({ auth, offers, bannerData, collectionsProducts }) {

    return (
        <>
            <Head title="Welcome" />
            <NavBar auth={auth}/>
            <AnnouncementBar offers={offers}/>
            <Banner bannerData={bannerData} />
            {/* <ProductsCardList list={list}/> */}

            {collectionsProducts.map(
                ({ collection, products }) => {
                    return (<ProductsCardList products={products} key={collection.id} collection={collection}/>)
                }
            )}

        </>
    );
}
