# Structure
This document will describe the structure of the project.

### Admin
The admin section will require a logged in user to have a "privilege" level of 50 or above to access the area.

I recommend that we create a module for the admin area. The new location for the admin area would then be:
`\application\modules\admin\`

Inside the module will be the following controllers with their actions listed below:
 - ~~UserController~~
  - ~~Create (Create a user)~~
  - ~~Edit (Edit a User)~~
  - Statistics (Display statistics about all the users)
 - ~~AssetController~~
  - ~~Create (Create an asset)~~
  - ~~Edit (Edit an asset)~~
  - Statistics (Display statistics about all the assets)

### User Area
This will also be known as "My Account" and will be accessible from the top right of a page where the logged in user would
click their name and access account settings etc.

This will be in the standard appication area (not in a module) and will comprise of the following:
 - AccountController
  - Profile (Edit their profile, their about etc.)
  - ~~Password (Edit their password, include confirmations of current password)~~
  - ~~Contact (Edit their mobile number, email address etc.)~~
  - ~~Assets (List all the assets owned by the user)~~
  - ~~Log Out (Allow the option to log out)~~

### Asset Area
This area will allow any user to view the asset.
This will comprise of the following:
 - AssetController
  ~~- View (View an asset and all its details)~~
  - Edit (If the user owns the asset, allow them to edit certain properties)
  - ~~Images (If the user owns the asset, allow them to upload images to the asset)~~

### Home Area
This is the home page, we already have the home controller.
We still need the search functions though.
This will comprise of the following:
 - HomeController
  ~~- Index (The index page with the search box, carousel, nav bar etc)~~
  - Results (We will call this dynamically within the page to display the results from the search)
