(function ($) {
  var defaultDomains = ['gmail', 'hotmail', 'yahoo', 'outlook', 'live', 'mail', 'icloud', 'web', 'comcast', 'siol'];
  var domainWords = defaultDomains;
  if (ase && ase.domains && ase.domains.length > 0) {
    domainWords = ase.domains;
  }

  var domainSuggester = autosuggestEmailValue({
    words: domainWords
  });

  var defaultTlds = ['com', 'com.au', 'com.tw', 'ca', 'co.nz', 'co.uk', 'de', 'fr', 'it', 'ru', 'net', 'org', 'edu', 'gov', 'jp', 'nl', 'kr', 'se', 'eu', 'ie', 'co.il', 'us', 'at', 'be', 'dk', 'hk', 'es', 'gr', 'ch', 'no', 'cz', 'in', 'net', 'net.au', 'info', 'biz', 'mil', 'co.jp', 'sg', 'hu', 'uk'];
  var tldWords = defaultTlds;
  if (ase && ase.tlds && ase.tlds.length > 0) {
    tldWords = ase.tlds;
  }

  var tldSuggester = autosuggestEmailValue({
    words: tldWords
  });

  $(document).ready(function () {
    if ($('.woocommerce-checkout')) {
      var typingTimer;
      var doneTypingInterval = 1000; // 1 second

      function doneTyping(input) {
        var email = $(input).val();
        if (email.indexOf('@') > -1) {
          var emailParts = email.split('@');
          var prefix = emailParts && emailParts.length > 0 ? emailParts[0] : '';
          var postfix = emailParts && emailParts.length > 1 ? emailParts[1] : '';

          if (prefix && postfix) {
            var postfixParts = postfix.replace(/\./, '&').split('&');
            var postfixPart1 = postfixParts && postfixParts[0] ? postfixParts[0] : '';
            var postfixPart2 = postfixParts && postfixParts[1] ? postfixParts[1] : '';

            if (postfixPart1) {
              postfixPart1 = domainSuggester(postfixPart1);
            }

            if (postfixPart2) {
              postfixPart2 = tldSuggester(postfixPart2);
            }

            if ($(input).val() !== `${prefix}@${postfixPart1}.${postfixPart2}`) {
              $(input).parent().find('.ase_suggestion').remove();
              $(input).parent().append(`<a href="#" data-suggestion="${prefix}@${postfixPart1}.${postfixPart2}" class="ase_suggestion">Did you mean ${prefix}@${postfixPart1}.${postfixPart2}?`);

              $('.ase_suggestion').on('click', function (e) {
                var suggestion = $(this).data('suggestion');
                $(this).parent().find('input[type=email]').val(suggestion);
                $(this).remove();
                e.preventDefault();
              });
            }
          }
        }
      }

      $('input[type=email]').each(function () {
        $(this).on('blur', function () {
          clearTimeout(typingTimer);
        });

        $(this).on('keydown', function () {
          clearTimeout(typingTimer);
        });

        $(this).on('keyup', function () {
          clearTimeout(typingTimer);

          var that = this;

          typingTimer = setTimeout(function () {
            doneTyping(that);
          }, doneTypingInterval);
        })
      });
    }
  });

}(jQuery));
