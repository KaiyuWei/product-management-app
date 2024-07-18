export default function SupplierHome() {
    return <>
        <div className = "p-3" >
            <div className = "text-2xl" >Purchase history</div >
            <div >
                Data table here showing which users purchased from this supplier.
                <p>
                    In the backend just make a query by "Orders" model, along with its "items" relationship. There is a "supplier_id" column for each order item, by which we can query the users who has made orders from a specific user.
                </p>
                <p>
                    $users = User::where
                </p>
            </div >
        </div >
    </>
}