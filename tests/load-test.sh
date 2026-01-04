#!/bin/bash

# Load Testing Script for STT Pratama Adi Website
# This script uses Apache Bench (ab) to test concurrent user load
# 
# Requirements:
#   - Apache Bench (ab) installed
#   - Application running on localhost:8000 or specified URL
#
# Usage: ./tests/load-test.sh [BASE_URL]
# Example: ./tests/load-test.sh http://localhost:8000

# Configuration
BASE_URL="${1:-http://localhost:8000}"
RESULTS_DIR="tests/load-test-results"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Create results directory
mkdir -p "$RESULTS_DIR"

echo "=========================================="
echo "Load Testing - STT Pratama Adi Website"
echo "=========================================="
echo "Base URL: $BASE_URL"
echo "Timestamp: $TIMESTAMP"
echo "Results will be saved to: $RESULTS_DIR"
echo ""

# Check if ab is installed
if ! command -v ab &> /dev/null; then
    echo -e "${RED}Error: Apache Bench (ab) is not installed${NC}"
    echo "Install it with:"
    echo "  Ubuntu/Debian: sudo apt-get install apache2-utils"
    echo "  macOS: brew install apache2"
    exit 1
fi

# Check if server is running
echo "Checking if server is running..."
if curl -s -o /dev/null -w "%{http_code}" "$BASE_URL" | grep -q "200\|302"; then
    echo -e "${GREEN}✓ Server is running${NC}"
else
    echo -e "${RED}✗ Server is not responding at $BASE_URL${NC}"
    echo "Please start the server first: php artisan serve"
    exit 1
fi

echo ""

# Function to run load test
run_test() {
    local name=$1
    local url=$2
    local requests=$3
    local concurrency=$4
    local output_file="$RESULTS_DIR/${TIMESTAMP}_${name}.txt"
    
    echo "----------------------------------------"
    echo "Test: $name"
    echo "URL: $url"
    echo "Requests: $requests"
    echo "Concurrency: $concurrency"
    echo "----------------------------------------"
    
    ab -n "$requests" -c "$concurrency" -g "$RESULTS_DIR/${TIMESTAMP}_${name}.tsv" "$url" > "$output_file" 2>&1
    
    # Extract key metrics
    local time_per_request=$(grep "Time per request:" "$output_file" | head -1 | awk '{print $4}')
    local requests_per_sec=$(grep "Requests per second:" "$output_file" | awk '{print $4}')
    local failed_requests=$(grep "Failed requests:" "$output_file" | awk '{print $3}')
    local time_taken=$(grep "Time taken for tests:" "$output_file" | awk '{print $5}')
    
    echo "Results:"
    echo "  Time taken: ${time_taken}s"
    echo "  Requests per second: $requests_per_sec"
    echo "  Time per request: ${time_per_request}ms"
    echo "  Failed requests: $failed_requests"
    
    # Check if test passed (< 3000ms per request)
    if (( $(echo "$time_per_request < 3000" | bc -l) )); then
        echo -e "  ${GREEN}✓ PASS${NC} (< 3000ms requirement)"
    else
        echo -e "  ${RED}✗ FAIL${NC} (> 3000ms requirement)"
    fi
    
    echo ""
}

# Test 1: Homepage - Light Load
run_test "homepage_light" "$BASE_URL/" 100 10

# Test 2: Homepage - Medium Load
run_test "homepage_medium" "$BASE_URL/" 500 50

# Test 3: Homepage - Heavy Load
run_test "homepage_heavy" "$BASE_URL/" 1000 100

# Test 4: Admin Login Page
run_test "admin_login" "$BASE_URL/admin/login" 100 10

# Test 5: Registration Page
run_test "registration" "$BASE_URL/registration/create" 100 10

# Test 6: CBT Login Page
run_test "cbt_login" "$BASE_URL/cbt/login" 100 10

echo "=========================================="
echo "Load Testing Complete"
echo "=========================================="
echo "Results saved to: $RESULTS_DIR"
echo ""
echo "To view detailed results:"
echo "  cat $RESULTS_DIR/${TIMESTAMP}_*.txt"
echo ""
echo "To generate graphs (requires gnuplot):"
echo "  gnuplot -e \"set terminal png; set output '$RESULTS_DIR/graph.png'; plot '$RESULTS_DIR/${TIMESTAMP}_homepage_heavy.tsv' using 2:5 with lines\""
echo ""
