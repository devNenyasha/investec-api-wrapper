# 🎄 Investec API Tips & Tricks

## OAuth Tips
- Store credentials securely (like hiding Christmas presents!)
- Use environment variables
- Token refresh happens automagically 🎅

## Did You Know?
- ICIB API needs an extra header (it's like a VIP pass to Santa's workshop)
- Private Banking API is super friendly (like Rudolf!)
- Card services may have delayed responses

## Rate Limiting
- Private Banking API: 100 requests per minute
- ICIB API: 60 requests per minute
- Use exponential backoff for retries
- Watch for 429 Too Many Requests responses

## Common Pitfalls
- Token expiration handling
- Rate limit considerations
- Error response formats

## Best Practices
- Use environment variables
- Implement proper logging
- Handle timeouts gracefully
