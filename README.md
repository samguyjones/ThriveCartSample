# ThriveCartSample

## Database

I started to by making a few classes to check some assumptions:

 * Products which handle things that can be sold.
 * Offers which are pieces of logic that can modify final cost.
 * Charge which are costs like shipping that modify the total.

Charge is probably too complicated.

I put all these in Doctrine and made a script to populate it with the test cases.

## Offers

So I made the Offer interface to handle offer-specific logic. So an offer
with the code `RedBogh` calls for instantiating \Model\Offer\RedBogh. To
handle the "Buy One Get Half" for red.

On reflection, it'd be nice to have a "data" field for Offer that contains
a JSON object. That way, I could have a Bogh field with an array of product
codes to say everything that's half off.

The offers are related to products so you know to not even check the logic
if the relevant product isn't being bought.

## Cart

The cart handles all the things. I had it hold a bunch of purchases which are
products + quantity. It's a little excessive, but it made a lot of things fast

 * I had the product objects available from the cart.
 * I had a quick thing to handle cost * quantity.
 * It let me keep the cart a little leaner.

For this exercise, the cart isn't permanent. If this were a real web app, this
would be another table, and purchase would act as a linking table to products.

You add purchases, which the cart builds as it goes. Then it computes the final
cost from subtotal (cost of products) + offset (possibly negative effect of offers)
+ shipping charges.

## Assumptions

I initially thought the second answer was a trick. I'd assumed that shipping is calculated
on the subtotal, but the second example only works if it's after offers. So if someone
ordered a $90.50 product and got a savings of .60, they would be charged $91.90 instead of
$91.50.

Also, I assumed the savings from half price would round down, but the example suggests it
rounds up.
