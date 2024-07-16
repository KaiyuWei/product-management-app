import { InputNumber, Stack } from 'rsuite';

export default function ProductCard ({name, price, inStock, description, supplierName, publishDate}) {


    return (
        <div className="card" style= {{width: '18rem'}} >
            <div className="card-body" >
                <h2 className="card-title text-lg" ><b>{name}</b></h2 >
                <ul className="list-group list-group-flush" >
                    <li className="list-group-item" ><b >Price: </b >{price}</li >
                    <li className="list-group-item" ><b >Available Stock: </b >{inStock}</li >
                    <li className="list-group-item" ><b >Description: </b >{description}</li >
                    <li className="list-group-item" ><b >From Supplier: </b >{supplierName}</li >
                    <li className="list-group-item" ><b >Publish Date: </b >{publishDate}</li >
                </ul >
                <div className="mt-2 grid grid-cols-2 gap-2" >
                    <Stack className="px-2 overflow-hidden">
                        <InputNumber min={0} placeholder="Number"/>
                    </Stack>
                    <button type="button" className="btn btn-primary" >Add To Cart</button >
                </div >
            </div >
        </div >);
}