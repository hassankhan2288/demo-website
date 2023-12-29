<?php

return [

    'account_id' => env('PAYMENTSENSE_ACCOUNT_ID', ""),
    'base_url'=>env('PAYMENTSENSE_BASE_URL', "https://e.test.connect.paymentsense.cloud/v1"),
    'jwt_token'=> env('PAYMENTSENSE_JWT_TOKEN', "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJjb25uZWN0LWUtcHJvZEBhcHBzcG90LmdzZXJ2aWNlYWNjb3VudC5jb20iLCJhdWQiOiJodHRwczovL2UuY29ubmVjdC5wYXltZW50c2Vuc2UuY2xvdWQiLCJleHAiOjI0Mzk0NzMwMzEsImlhdCI6MTY4MjYwOTAzMSwic3ViIjoiY29ubmVjdC1lLXByb2RAYXBwc3BvdC5nc2VydmljZWFjY291bnQuY29tIiwiYXBpS2V5IjoiMzM0OGFkOGUtMTIxZi00MjNiLWI2YWItMmMyYjYyZTI4Y2M1IiwiZW1haWwiOiJjb25uZWN0LWUtcHJvZEBhcHBzcG90LmdzZXJ2aWNlYWNjb3VudC5jb20ifQ.el09Mxw-y4xyCrRI8BUkHLIPRnp3s9Hsf1i16g4AkXY4A6EqMv2jV8chdJNg7YvS-glcuLPO-CD-egJaqouwbPREihVX7Zuq1FilpqhP4Whs3dhxsicBDSoFXWqThRMx_FyttIX60l8uDhCy6SSnE93Ru82D1Z8FbVjSc24xejkzIIzz94jV5hdJ7Uep-g6zGZhoZlX_O_VNEw-ZeRi3dU7ePkIdFo554gDGCqOJsBL5qbLCimQ2YdmsVqQSzB6uy1D9m1TgA0V6Yf2zcm5SNPaR2WnoqnU7zB86rz2Mct8qT2isHgSCwp2NgwFNS5mLlJc3y1m0Pt9R2pyEdHdrZQ"),
    'merchant_id' => env('PAYMENTSENSE_MERCHANT_ID', ""),
    'api_key' => env('PAYMENTSENSE_API_KEY'),
    'secret_key' => env('PAYMENTSENSE_SECRET_KEY'),
    'key_alias' => env('PAYMENTSENSE_KEY_ALIAS'),
    'key_pass' => env('PAYMENTSENSE_KEY_PASS'),
    'key_id' => env('PAYMENTSENSE_KEY_ID'),
    'encrypted_api_key' => env('PAYMENTSENSE_ENCRYPTED_API_KEY'),

];
