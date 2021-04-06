Features

The features requested must apply to the magento backend only, not on frontend.
● In the user view in magento (system > all users > [select user]), add a new tab “Website
    permission”. This tab contains only one control :
    ○ Control label : Website
    ○ Control : dropdown populated with all magento websites
    ○ This parameter is optional, meaning that the first option is empty with label “-- All
    --”
    ○ The website attached to user must be stored in table admin_user, in column
    “website_id”
● Products list :
    ○ Everywhere there is a list of products in magento backend, if the current user is
    associated to a specific website, you must limit the list of products to the ones
    associated to the user website.
    ○ If user has no website, do not restrict the list of the products
    ○ This restriction should apply to every screen with products list:
    ■ Catalog > Products
    ■ Listing of products for a category (in the category view in backend)
    ■ Listing of products when we create a new order in backend
    ■ Related products tab in the product view (backend)

● Product view
    ○ When user goes in the product view in magento (controller catalog/product/edit),
    if the user tries to see a product that does not belong to its website, he should
    have an error message