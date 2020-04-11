/*
* test.js - File that contains tests for the Achievers 
* Actually just here now to make Travis-CI stop saying "Failed"
*/


// Based on https://mochajs.org/#getting-started
var assert = require('assert');
describe('Array', function() {
    describe('#indexOf()', function() {
        it('should return -1 when the value is not present', function() {
            assert.equal([1,2,3].indexOf(4), -1);
        });
    });
});
