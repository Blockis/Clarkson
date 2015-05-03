; Paul Burgwardt
; CS341 Programming Languages
; HW1

(define my-prefix?
  (lambda (ls1 ls2)
    (cond ((null? ls1) #t)
          ((null? ls2) #f)
          ((equal? (car ls1) (car ls2))
           (my-prefix? (cdr ls1) (cdr ls2))) (else #f))))

(define my-subsequence?
  (lambda (ls1 ls2)
    (cond ((null? ls1) #t)
          ((null? ls2) #f)
          ((my-prefix? ls1 ls2) #t)
          (else (my-subsequence? ls1 (cdr ls2))))))

; exist?
(define exists?
  (lambda (item ls)
    (cond ((null? ls) #f)
          ((equal? item (car ls)) #t)
          (else (exists? item (cdr ls))))))

; whos-on-first-loop
(define whos-on-first-loop
  (lambda (old-context)
    (let ((costellos-line (read)))
      (let ((new-context (get-context costellos-line old-context)))
        (let ((strong-reply (try-strong-cues costellos-line)))
          (let ((weak-reply (try-weak-cues costellos-line new-context)))
            (cond ((not (null? strong-reply))
                   (writeln strong-reply)
                   (whos-on-first-loop (get-context strong-reply new-context)))
                  ((not (null? weak-reply))
                   (writeln weak-reply)
                   (whos-on-first-loop (get-context weak-reply new-context)))
                  ((wants-to-end? costellos-line)
                   (wrap-it-up))
                  (else
                   (writeln (hedge))
                   (whos-on-first-loop new-context)))))))))

; try-strong-cues: stub
(define try-strong-cues
  (lambda (sentence)
    (letrec
        ((helper
          (lambda (cues-responses)
            (cond ((null? cues-responses) '())
                  ((any-good-fragments? sentence (cue-part (car cues-responses)))
                   (select-any-from-list (response-part (car cues-responses))))
                  (else
                   (helper (cdr cues-responses)))))))
      (helper *strong-cues*))))

(define cue-part
  (lambda (pair)
    (car pair)))

(define response-part
  (lambda (pair)
    (car (cdr pair))))

; any good-fragments?:
; test if a sentence contains one of the patterns in a list of cues
(define any-good-fragments?
  (lambda (sentence list-of-cues)
    (cond ((null? list-of-cues) #f)
          ((my-subsequence? (car list-of-cues) sentence) #t)
          (else (any-good-fragments? sentence (cdr list-of-cues))))))

; select-any-from-list
(define select-any-from-list
  (lambda (ls)
    (list-ref ls (random (length ls)))))

; *strong-cues*:
; list of strong cues
(define *strong-cues*
	  '( ( ((the names) (their names))
	       ((whos on first whats on second i dont know on third)
 	        (whats on second whos on first i dont know on third)) )

	     ( ((suppose) (lets say) (assume))
	       ((okay) (why not) (sure) (it could happen)) )

	     ( ((i dont know))
	       ((third base) (hes on third)) )
	   ))

; hedge
(define hedge
  (lambda ()
    (select-any-from-list *hedges*)))

(define *hedges*
	  '((its like im telling you)
	    (now calm down)
	    (take it easy)
	    (its elementary lou)
	    (im trying to tell you)
	    (but you asked)))

; get-context: stub
(define get-context
  (lambda (sentence old-context)
    (letrec
        ((helper
          (lambda (list-of-context)
            (cond ((null? list-of-context) old-context)
                  ((any-good-fragments? sentence (cue-part (car list-of-context))) (context-part (car list-of-context)))
                  (else (helper (cdr list-of-context)))))))
      (helper *context-words*))))

(define context-part
  (lambda (pair)
    (cadr pair)))

(define context-responses
  (lambda (pair)
    (cdr pair)))

(define *context-words*
	  `( ( ((first)) first-base )
	     ( ((second)) second-base )
	     ( ((third)) third-base )))

; want-to-end?
(define wants-to-end?
  (lambda (sentence)
    (exists? sentence *exit-phrases*)))

(define *exit-phrases*
  '((i quit)
    (stop it)
    (i dislike you)))

; wrap-it-up
(define wrap-it-up
  (lambda ()
    (writeln '(have a good day))))

(define try-weak-cues
  (lambda (sentence new-context)
    (define helper1
      (lambda (cues-responses)
        (cond ((null? cues-responses) '())
              ((any-good-fragments? sentence (cue-part (car cues-responses)))
               (helper2 (context-responses (car cues-responses))))
              (else (helper1 (cdr cues-responses))))))
    (define helper2
      (lambda (ls)
        (cond ((null? ls) '())
              ((exists? new-context (car (car ls)))
               (select-any-from-list (response-part (car ls))))
              (else (helper2 (cdr ls))))))
    (helper1 *weak-cues*)))

(define *weak-cues*
  '( ( ((who) (whos) (who is))
       ((first-base)
           ((thats right) (exactly) (you got it)
	    (right on) (now youve got it)))
       ((second-base third-base)
           ((no whos on first) (whos on first) (first base))) )
     ( ((what) (whats) (what is))
       ((first-base third-base)
	   ((hes on second) (i told you whats on second)))
       ((second-base)
	   ((right) (sure) (you got it right))) )
     ( ((whats the name))
       ((first-base third-base)
	   ((no whats the name of the guy on second)
	    (whats the name of the second baseman)))
       ((second-base)
	((now youre talking) (you got it))))
   ))

(define writeln
  (lambda (sentence)
    (write sentence)
    (display "\n")))

; Test Jig
(define test-me
  (lambda ()
    (whos-on-first-loop '())))