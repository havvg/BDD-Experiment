Feature: Navigating the categories within the catalog
  In order to view the products within the catalog
  As a visitor
  I want to browse the categories

  Background:
    Given There is no "Product" in database
      And There is no "Category" in database
      And I have a category "Underwear"
      And I have a category "Shoes"

  Scenario: The categories are being listed
    Given I am on "/categories"
     Then I should see a "ul#category-list" element
      And I should see "Shoes" in the "#category-list" element
      And I should see "Underwear" in the "#category-list" element

  Scenario: The categories link to their products list
    Given I am on "/categories"
      And I have a product "Calvin Klein Black, 5"
      And I add product "Calvin Klein Black, 5" to category "Underwear"
      And I have a product "Converse All Star, 8"
      And I add product "Converse All Star, 8" to category "Shoes"
     When I follow "Underwear"
     Then I should see "Calvin Klein Black, 5" in the "#product-list li" element
      And I should not see "Converse All Star, 8"
     When I move backward one page
      And I follow "Shoes"
     Then I should see "Converse All Star, 8" in the "#product-list li" element
      And I should not see "Calvin Klein Black, 5"