## Use The App
1. Run `docker-compose up` to start the database, backend and frontend container.
2. After the containers are up, visit `http://localhost:3000/`. you will be redirected to login page.
3. By clicking the "Register" button in the top nav bar, you can register users. There are two role options that you need to select: 
   - supplier: users who publish and sell products.
   - customer: users who buy products.
4. For Suppliers, you can publish products by clicking the dropdown menu: User->Dashboard
5. For Customers, you will see all products published by all suppliers. You can add products to your cart in your homepage. After adding products, you can place the order in User->Dashboard->Cart. The stock of the products you buy is changed after the order is placed.

## Highlight
1. Proper data structure in Laravel backend and React frontend.
2. Use Sanctum to do single-page authentication.
2. Try to avoid "N+1" problems by using eagerloading.
3. Try to avoid DB accidental fail when multiple operations need to be executed by using DB transactions
4. Use of docker and docker composer for easier testing and demonstration.

## ShortCuts and improvement
1. For both suppliers and customers, more CRUD operations and api endpoints are needed, e.g. delete products, delete orders, edit cart, edit orders, etc. 
2. Merge product with the same uuid for a supplier (need uuid for product). Currently everytime a supplier publish products, a new item is created, even if the product has been published before. 
3. Order and Stock logic: For now when some products are added to a user's cart, the stock is not updated until the user finally place the order. But in practice, this can lead to conflict if a user add product into cart but do not pay for a long time. Then when the user is ready to buy, the stock might be already run out. Solution for this problem:
    - When a user add products to cart, or to order in practice, there should be a time limit within which user needs to pay and place the order. If the user does not pay in limited time, then the items are removed from his cart or order. This can be done by set a delayed task in rabbitmq. Besides, always check the stock before the user pays.
    - When a user is about to pay for an order, add a lock to the product stock in DB. in the payment process, any other update to relevant products stock in DB is not allowed. The lock is lifted until the user completes the payment and the product stock is updated.
4. Validation in the frontend to reduce the server load.
8. Add filter, sorter, pagination for product data fetch.
9. Email verification when a user registers.
10. Time is not enough for making the user order history page, and the page where suppliers can view which users bought your products.
10. Password reset in case of forgetting password.
11. From a practical perspective, maybe separate supplier and customer domains (easier to manage and maintain).
12. Product detail page where you can operate on a product (check the details, add to cart, buy, check comments..)
13. Payment process instead of directly make order without considering monetary things.
14. When a products’ stock is 0 it should be deleted from the DB and not displayed in the home page of customers.
15. The “buy” button should be disabled when there’s nothing in user’s cart.
16. Coding style: I've always tried to write clean code by using descriptive names and shorter functions as much as possible. But because there was much work to do, some part can be a bit messy. If I have more time, I would think more about how to make the code more readable as I usually do.
17. Better frontend page designing.