<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['page_id' => 3, 'filed_name' => 'Top Paragraph', 'title' => 'Top Paragraph', 'description' => 'Top Paragraph', 'status' => 1],
            ['page_id' => 3, 'filed_name' => 'User Account', 'title' => 'User Account', 'description' => 'User Account', 'status' => 1],
            ['page_id' => 3, 'filed_name' => 'Product Ordering', 'title' => 'Product Ordering', 'description' => 'Product Ordering', 'status' => 1],
            ['page_id' => 3, 'filed_name' => 'Return and Refund', 'title' => 'Return and Refund', 'description' => 'Return and Refund', 'status' => 1],
            ['page_id' => 3, 'filed_name' => 'Contact', 'title' => 'Contact', 'description' => 'Contact', 'status' => 1],
            ['page_id' => 3, 'filed_name' => 'Product Descriptions', 'title' => 'Product Descriptions', 'description' => 'Product Descriptions', 'status' => 1],
            ['page_id' => 3, 'filed_name' => 'Payment Method', 'title' => 'Payment Method', 'description' => 'Payment Method', 'status' => 1],
            ['page_id' => 3, 'filed_name' => 'Shipping Guide', 'title' => 'Shipping Guide', 'description' => 'Shipping Guide', 'status' => 1],
            ['page_id' => 3, 'filed_name' => 'Locations We Ship To', 'title' => 'Locations We Ship To', 'description' => 'Locations We Ship To', 'status' => 1],

            ['page_id' => 2, 'filed_name' => 'Top Paragraph', 'title' => 'Top Paragraph', 'description' => 'Top Paragraph', 'status' => 1],
            ['page_id' => 2, 'filed_name' => 'User Account', 'title' => 'User Account', 'description' => 'User Account', 'status' => 1],
            ['page_id' => 2, 'filed_name' => 'Product Ordering', 'title' => 'Product Ordering', 'description' => 'Product Ordering', 'status' => 1],
            ['page_id' => 2, 'filed_name' => 'Return and Refund', 'title' => 'Return and Refund ', 'description' => 'Return and Refund ', 'status' => 1],
            ['page_id' => 2, 'filed_name' => 'Contact', 'title' => 'Contact ', 'description' => 'Contact ', 'status' => 1],
            ['page_id' => 2, 'filed_name' => 'Product Descriptions', 'title' => 'Product Descriptions ', 'description' => 'Product Descriptions ', 'status' => 1],
            ['page_id' => 2, 'filed_name' => 'Payment Method', 'title' => 'Payment Method', 'description' => 'Payment Method', 'status' => 1],
            ['page_id' => 2, 'filed_name' => 'Shipping Guide', 'title' => 'Shipping Guide', 'description' => 'Shipping Guide', 'status' => 1],
            ['page_id' => 2, 'filed_name' => 'Locations We Ship To', 'title' => 'Locations We Ship To', 'description' => 'Locations We Ship To', 'status' => 1],

            ['page_id' => 1, 'filed_name' => 'About Us', 'title' => 'About Us', 'description' => 'About Us', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'Mission', 'title' => 'Mission', 'description' => 'Mission', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'Vision', 'title' => 'Vision', 'description' => 'Vision', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'Quality Products in Affordable Prices', 'title' => 'Quality Products in Affordable Prices', 'description' => 'Quality Products in Affordable Prices', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'Best delivery options', 'title' => 'Best delivery options', 'description' => 'Best delivery options', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'Trustworthy', 'title' => 'Trustworthy', 'description' => 'Trustworthy', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'Customer Service', 'title' => 'Customer Service', 'description' => 'Customer Service', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'Orders and Returns', 'title' => 'Orders and Returns', 'description' => 'Orders and Returns', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'How to Order', 'title' => 'How to Order', 'description' => 'How to Order', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'How to Return and Refund', 'title' => 'How to Return and Refund', 'description' => 'How to Return and Refund', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'Contact', 'title' => 'Contact', 'description' => 'Contact', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'Payment Method', 'title' => 'Payment Method', 'description' => 'Payment Method', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'Shipping Guide', 'title' => 'Shipping Guide', 'description' => 'Shipping Guide', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'Locations we ship to', 'title' => 'Locations we ship to', 'description' => 'Locations we ship to', 'status' => 1],
            ['page_id' => 1, 'filed_name' => 'Estimated Delivery Time', 'title' => 'Estimated Delivery Time', 'description' => 'Estimated Delivery Time', 'status' => 1],
        ];

        PageContent::truncate();

        foreach ($data as $content) {
            PageContent::create($content);
        }

    }
}
