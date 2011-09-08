Feature: Product Category Relationship
  In order to setup a valid catalog
  As a developer
  I need a working relationship

  Background:
    Given There is no "Product" in database
      And There is no "Category" in database

  Scenario: A category contains a product
    Given I have a category "Underwear"
      And I have a product "Calvin Klein Black, 5"
     When I add product "Calvin Klein Black, 5" to category "Underwear"
     Then I should find product "Calvin Klein Black, 5" in category "Underwear"

  Scenario: A category contains more than 1 product
    Given I have a category "Underwear"
      And I have a product "Calvin Klein Black, 5"
      And I have a product "Calvin Klein White, 5"
     When I add product "Calvin Klein Black, 5" to category "Underwear"
      And I add product "Calvin Klein White, 5" to category "Underwear"
     Then I should find product "Calvin Klein Black, 5" in category "Underwear"
      And I should find product "Calvin Klein White, 5" in category "Underwear"

  Scenario: A product is part of more than 1 category
    Given I have a product "Calvin Klein Black, 5"
      And I have a category "Underwear"
      And I have a category "Men"
     When I add product "Calvin Klein Black, 5" to category "Underwear"
      And I add product "Calvin Klein Black, 5" to category "Men"
     Then I should find product "Calvin Klein Black, 5" in category "Underwear"
      And I should find product "Calvin Klein Black, 5" in category "Men"