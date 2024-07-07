import quanchecker

headers = [{
  'Content-Type': 'application/json'
}]

test_cases = [
    {
        'checking_method': quanchecker.response_based_check,
        'url': "http://localhost:(port)/items?name=item 1",
        'header': headers[0],
        'method': 'GET',
        'body': "",
        'expected': '{"message":"Database connection successful"}[{"id":"1","name":"Item 1","description":"Description for Item 1"}]',
    },
    {
        'checking_method': quanchecker.response_based_check,
        'url': "http://localhost:(port)/items?name=Item'3",
        'header': headers[0],
        'method': 'GET',
        'body': "",
        'expected': '{"message":"Database connection successful"}[{"id":"3","name":"Item\'3","description":"Description for Item 3"}]',
    },
    {
        'checking_method': quanchecker.response_based_check,
        'url': "http://localhost:(port)/items?name=NonExistingItem",
        'header': headers[0],
        'method': 'GET',
        'body': "",
        'expected': '{"message":"Database connection successful"}{"message":"No item found with the provided name"}',
    },
    {
        'checking_method': quanchecker.response_based_check,
        'url': "http://localhost:(port)/items?name=' OR '1'='1",
        'header': headers[0],
        'method': 'GET',
        'body': "",
        'expected': '{"message":"Database connection successful"}{"message":"No item found with the provided name"}',
    },
    {
        'checking_method': quanchecker.response_based_check,
        'url': "http://localhost:(port)/items?name=%27%20OR%20%271%27=%271",
        'header': headers[0],
        'method': 'GET',
        'body': "",
        'expected': '{"message":"Database connection successful"}{"message":"No item found with the provided name"}',
    }
]

quanchecker.run_tests_dev(test_cases)