/*
* test.js - File that contains tests for the Achievers 
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



var account = require('../account.js');

// Next four lines from https://stackoverflow.com/questions/43960608/setting-up-jsdom-with-mocha/43964899
const {JSDOM} = require('jsdom');
/*
const dom = new JSDOM('<!DOCTYPE html><html><head></head><body></body></html>', { runScripts: "dangerously" });
global.window = dom.window;
global.document = dom.window.document;
CreateFields();
*/

describe('accountCreate', function() {
    //  before() from https://stackoverflow.com/questions/57113871/jsdom-document-is-not-defined
    it('should not return an error', function() {
        let jsdom;
        before(async function() {
            jsdom = await JSDOM.fromFile("Signup.html", {
                resources: "usable",
                runScripts: "dangerously"
            });
            
            await new Promise(resolve =>
                jsdom.window.addEventListener('DOMContentLoaded', SetFields("","","",""), resolve)
        
                );
        });
        assert(account.accountCreate(), "accountCreate failed to fail???");

        });

});


function CreateFields() {
    document.createElement('Username');
    document.createElement('Password');
    document.createElement('Email');
    document.createElement('ConfirmPass');
}

function SetFields(un, pw, em, cp) {
    document.getElementById('Username').value       = un;
    document.getElementById('Password').value       = pw;
    document.getElementById('Email').value          = em;
    document.getElementById('ConfirmPass').value    = cp;
}
